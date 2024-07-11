const formatPrice = (price) => {
    const formatedPrice = new Intl.NumberFormat("es-CL").format(price);
    return `${formatedPrice}`;
  };
  
  export default formatPrice;
  