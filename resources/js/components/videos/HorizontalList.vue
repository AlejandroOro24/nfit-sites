<template>
        <div class="col-18 col-14-xl tags-wrapper" ref="container">
            <div class="tags-left" @click="prev" v-if="_hasPrev">
                <img :src="'/icons/arrow-left.svg'" alt="Ver más" class="icon-left">
            </div>
            <p ref="iz"></p>
            <div class="tags" ref="list">
                <a href="#" ref="item" :class="{ 'active': activeAll }" @click="allTypes" class="tag">Todos</a>
                <a ref="item" :class="{ 'active': item.clicked }" @click="toggleItem(item, $event)" type="radio" v-for="item in items" :key="item.id" class="tag">
                    {{ item.clase_type }}
                </a>
            </div>
            <p ref="de"></p>
            <div class="tags-right" @click="next" ref="de" v-if="_hasNext">
                <img :src="'/icons/arrow-right.svg'" alt="Ver más" class="icon-right">
            </div>
        </div>
</template>

<script>
export default {
    name: 'Horizontal-list',
    data() {
        return {
            position: 0,  /** Current item position of list */
            start_point: 0,  /**  Position start of the horizontal list  */
            end_point: 0,  /**  finish position of the horizontal list  */
            activeAll: true
        }
    },
    props: {
        /** items to display in horizontal-list */
        items: { type: Array, required: true },
    },
    mounted() {
// console.log('montado horizontal list');
        /**  Get start point reference of the horizontal list */
        let iz = this.$refs.iz;
        /**  Get end point reference of the horizontal list */
        let de = this.$refs.de;
        // Get specific position of the start point reference
        this.start_point = iz.getBoundingClientRect().right - 300;
        // Get specific position of the end point reference
        this.end_point = de.getBoundingClientRect().right - 50;
    },
    computed: {
        _items() {
            return [
                ...this.items.map((value) => ({ type: "item", item: value })),
            ];
        },
        /**  Whether there is next set of items for navigation  */
        _hasPrev() {
            return this.position > this.start_point;
        },
        /**  whether there is prev set of items for navigation  */
        _hasNext() {
            return this.position < this.end_point;
        },
    },
    methods: {
        /**  Go to the left into the list */
        prev() {
            this.position -= 200;
            if (this.position < this.start_point) {
                this.position = this.start_point
            }
            this.go(this.position);
        },
        /**  Go to the right into the list */
        next() {
            this.position += 200;
            if (this.position > this.end_point) {
                this.position = this.end_point
            }
            this.go(this.position);
        },
        /**
         *  Scroll to an specific position inside the list
         *
         *  @param  position  The position to has to be moved
         */
        go(position) {
            this.$refs.list.scrollTo({ top: 0, left: this.position, behavior: "smooth" });
        },
        /**  Select an specific clase type (just allowed one at time) */
        toggleItem(item, e) {
            this.activeAll = false;
            if (e.ctrlKey) {
                item.clicked = !item.clicked;
            } else {
                this.deselectAllTypes();
                item.clicked = true;
                this.$emit("nombre", item.id);
            }
        },
        // select all types clases to be displayed
        allTypes() {
            this.deselectAllTypes();
            this.$emit("nombre", 0);
            this.activeAll = true;
        },
        /** Deselect all types of clases (to remove "active" css class) */
        deselectAllTypes() {
            this.items.forEach(function(entry) {
                entry.clicked = false;
            });
        }
    },
}
</script>
