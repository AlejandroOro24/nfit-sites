window.onload = function() {

    // Toggle Mobile Menu
    const mobileToggler = document.querySelector('#mobileToggler');
    const menu = document.querySelector('#menu');
    const aside = document.querySelector('#aside');
    // const htmlBody = document.querySelector('html');

    mobileToggler.onclick = (e) => {
        aside.classList.toggle('full-height');
        menu.classList.toggle('active');
        e.preventDefault();
    }

    // Collapse Desktop Menu
    const desktopToggler = document.querySelector('#desktopToggler');
    const desktopTogglerImg = document.querySelector('.desktop-collapse span');
    const main = document.querySelector('main');

    // desktopToggler.onclick = (e) => {
    //     // desktopTogglerImg.classList.toggle('collapsed');
    //     //aside.classList.toggle('desktop-collapsed');
    //     main.classList.toggle('full-spacing');
    //     e.preventDefault();
    // }

    // Toggle Alerts Wrapper
    const alertToggler = document.querySelector('.alerts .icon-notification');
    const alertsWrapper = document.querySelector('.alerts');
    const notificationWrapper = document.querySelector('.notification-wrapper');

    // alertToggler.onclick = (e) => {
    //     alertsWrapper.classList.toggle('overflow-visible');
    //     notificationWrapper.classList.toggle('show');
    //     if (alertsWrapper.classList.contains('overflow-visible')) {
    //         profileAvatar.classList.remove('overflow-visible');
    //         profileWrapper.classList.remove('show');
    //     }
    // }

    // Toggle Profile Wrapper
    const profileToggler = document.querySelector('.profile-avatar .avatar-icon');
    const profileWrapper = document.querySelector('.profile-avatar .profile-wrapper');
    const profileAvatar = document.querySelector('.profile-avatar');

    profileToggler.onclick = (e) => {
        profileAvatar.classList.toggle('overflow-visible');
        profileWrapper.classList.toggle('show');
        // notificationWrapper.classList.toggle('show');
        if (profileAvatar.classList.contains('overflow-visible')) {
            alertsWrapper.classList.remove('overflow-visible');
            notificationWrapper.classList.remove('show');
        }
    }

    // M O D A L S 
    // New Reservation
    const html = document.querySelector('html');
    const triggerNewReservation = document.querySelector('#trigerModal-newReservation');
    const modalNewReservation = document.querySelector('#sideModal-newReservation');
    const titleNewReservation = document.querySelector('#sideModal-newReservation .modal-header .title');

    // // Toggle Modal Open: New Reservation
    // if (triggerNewReservation) {
    //     triggerNewReservation.onclick = () => {
    //         modalNewReservation.classList.add('open');
    //         modalNewReservation.classList.remove('close');
    //         html.classList.add('o-hidden');
    //     }
    // }

    // // Toggle Modal Close: New Reservation
    // if (titleNewReservation) {
    //     titleNewReservation.onclick = () => {
    //         modalNewReservation.classList.add('close');
    //         html.classList.remove('o-hidden');
    //         setTimeout(function(){
    //             modalNewReservation.classList.remove('open');
    //             modalNewReservation.classList.remove('close');
    //             modalNewReservation.classList.add('d-none');
    //         }, 600
    //         );
    //     }
    // }

    // const collapsableItem = document.querySelectorAll('.collapsable');
    const collapsableItemHeading = document.querySelectorAll('.collapsable .modal-section-heading');
    // const collapsableItemHeading = document.querySelectorAll('.collapsable'+':before');

    // Toggle Collapsable
    for (var i = 0; i < collapsableItemHeading.length; i++) {
        // collapsableItemHeading[i].addEventListener("click", function(){
        collapsableItemHeading[i].addEventListener("click", function(){
            
            // console.log('se hizo click en '+i);
            this.parentNode.classList.toggle("closed");
            
        }, false);
    }

    const optionClass = document.querySelectorAll('.classOptions .option'+':not(.disabled)');
    const optionDay = document.querySelectorAll('.dayOptions .option'+':not(.disabled)');
    const optionHour = document.querySelectorAll('.hourOptions .option-large'+':not(.disabled)');

    // Select a Class Option
    for (var i = 0; i < optionClass.length; i++) {
        optionClass[i].addEventListener("click", function(){
            
            var selectedEl = document.querySelector(".classOptions .selected");
            if(selectedEl){
                selectedEl.classList.remove("selected");
            }
            this.classList.add("selected");
            
        }, false);
    }

    // Select a Day Option
    for (var i = 0; i < optionDay.length; i++) {
        optionDay[i].addEventListener("click", function(){
                
            var selectedEl = document.querySelector(".dayOptions .selected");
            if(selectedEl){
                selectedEl.classList.remove("selected");
            }
            this.classList.add("selected");
            
        }, false);
    }

    // Select a Hour Option
    for (var i = 0; i < optionHour.length; i++) {
        optionHour[i].addEventListener("click", function(){
            
            var selectedEl = document.querySelector(".hourOptions .selected");
            if(selectedEl){
                selectedEl.classList.remove("selected");
            }
            this.classList.add("selected");
            
        }, false);
    }

    // Modal Confirm
    // const triggerModalConfirm = document.querySelector('.trigerModal-confirm');
    // const triggerModalLeave = document.querySelector('.trigerModal-leave');
    // const triggerModalConfirmPlan = document.querySelector('.trigerModal-confirmPlan');
    // const modalConfirm = document.querySelector('#centerModal-confirm');
    // const modalLeave = document.querySelector('#centerModal-leave');
    // const modalConfirmPlan = document.querySelector('#centerModal-confirmPlan');
    // const triggerCloseConfirm = document.querySelector('#centerModal-confirm .center-modal .modal-heading');
    // const triggerCloseLeave = document.querySelector('#centerModal-leave .center-modal .modal-heading');
    // const triggerCloseConfirmPlan = document.querySelector('#centerModal-confirmPlan .center-modal .modal-heading');

    // // Toggle Modal Open: Confirm Alert
    // if(triggerModalConfirm) {
    //     triggerModalConfirm.onclick = () => {
    //         modalConfirm.classList.add('open');
    //         modalConfirm.classList.remove('close');
    //         html.classList.add('o-hidden');
    //     }
    // }

    // // Toggle Modal Close: Confirm Alert
    // if(triggerCloseConfirm) {
    //     triggerCloseConfirm.onclick = () => {
    //         modalConfirm.classList.add('close');
    //         html.classList.remove('o-hidden');
    //         setTimeout(function(){
    //             modalConfirm.classList.remove('open');
    //             modalConfirm.classList.remove('close');
    //            // modalConfirm.classList.add('d-none');
    //         }, 600
    //         );
    //     }
    // }

    // Toggle Modal Open: Leave Alert
    // if (triggerModalLeave) {
    //     triggerModalLeave.onclick = () => {
    //         modalLeave.classList.add('open');
    //         modalLeave.classList.remove('close');
    //         html.classList.add('o-hidden');
    //     }
    // }

    // // Toggle Modal Close: Leave Alert
    // if(triggerCloseLeave) {
    //     triggerCloseLeave.onclick = () => {
    //         modalLeave.classList.add('close');
    //         html.classList.remove('o-hidden');
    //         setTimeout(function(){
    //             modalLeave.classList.remove('open');
    //             modalLeave.classList.remove('close');
    //             modalLeave.classList.add('d-none');
    //         }, 600
    //         );
    //     }
    //}

    // Toggle Modal Open: Confirm Plan
    // if(triggerModalConfirmPlan) {
    //     triggerModalConfirmPlan.onclick = () => {
    //         modalConfirmPlan.classList.add('open');
    //         modalConfirmPlan.classList.remove('close');
    //         html.classList.add('o-hidden');
    //     }
    // }

    // Toggle Modal Close: Confirm Plan
    // if(triggerCloseConfirmPlan) {
    //     triggerCloseConfirmPlan.onclick = () => {
    //         modalConfirmPlan.classList.add('close');
    //         html.classList.remove('o-hidden');
    //         setTimeout(function(){
    //             modalConfirmPlan.classList.remove('open');
    //             modalConfirmPlan.classList.remove('close');
    //             modalConfirmPlan.classList.add('d-none');
    //         }, 600
    //         );
    //     }
    // }

    // Video Box Tabs
    const tabs = document.querySelectorAll('.single-video-box .header > .link-tab');

    function tabsClicks(tabClickEvent) {

        for (let i = 0; i < tabs.length; i++) {
            // let clickedTab = tabClickEvent.currentTarget;
            if (tabs[i].classList.contains('active')){
                tabs[i].classList.remove('active');
            } else {
                tabs[i].classList.add('active');
            }
            tabClickEvent.preventDefault();
        }


        let contentPanes = document.querySelectorAll('.tab-content');
        for (i = 0; i < contentPanes.length; i++) {
            // console.log(contentPanes[i]);
            if(contentPanes[i].classList.contains('active')) {
                contentPanes[i].classList.remove("active");
            } else {
                contentPanes[i].classList.add("active");
            }
        }

        // var anchorReference = tabClickEvent.target;
		// var activePaneId = anchorReference.getAttribute("href");
		// var activePane = document.querySelector(activePaneId);
        // activePane.classList.add("active");
        
    }

    for (i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", tabsClicks)
    }

    // Toggle Answers
    const singleVideoBoxAnswers = document.querySelectorAll('.box-comentarios .tab-content-body .comments .comment .comment-footer .answers');

    for (i = 0; i < singleVideoBoxAnswers.length; i++) {
        (function(index){
            singleVideoBoxAnswers[index].onclick = () => {
                singleVideoBoxAnswers[index].classList.toggle('active');
                singleVideoBoxAnswers[index].parentNode.parentNode.querySelector('.replies').classList.toggle('active');
                // console.log(singleVideoBoxAnswers[index]);
            }
        }(i));
    }

    // Trigger Toasts (Funciona con la clase ".trigger-toast")
    const triggerToast = document.querySelector('.trigger-toast');
    const toast = document.querySelector('.toast');

    if(triggerToast) {
        triggerToast.onclick = () => {
            // console.log('click');
            toast.classList.add('d-inherit');
            toast.classList.add('show');
            toast.classList.remove('hide');
            toast.onclick = () => {
                toast.classList.add('hide');
                setTimeout(function(){
                    toast.classList.remove('d-inherit');
                    toast.classList.remove('show');
                }, 700)
            }
        }
    }

    const selectCategory = document.querySelectorAll('.navigation a');

    for (var i = 0, l = selectCategory.length; i < l; i++) {
        selectCategory[i].onclick = function() {
            for (var j = 0; j < l; j++) {
            if (selectCategory[j] != this) {
                selectCategory[j].classList.remove("active");
            }
            }
            this.classList.toggle('active');
        }
    }

}
    