let searchForm = document.querySelector('.search-form');

document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('search-active');
    cart.classList.remove('cart-active');
    registerForm.classList.remove('login-active');
    loginForm.classList.remove('login-active');
    navbar.classList.remove('navbar-active');
}

let cart = document.querySelector('.shopping-cart');

document.querySelector('#cart-btn').onclick = () =>{
    cart.classList.toggle('cart-active');
    searchForm.classList.remove('search-active');
    registerForm.classList.remove('login-active');
    loginForm.classList.remove('login-active');
    navbar.classList.remove('navbar-active');
}

let loginForm = document.querySelector('.login-form');


if(document.querySelector('#login-btn') != null){
    document.querySelector('#login-btn').onclick = () =>{
        if(registerForm.classList.contains('login-active')){
            registerForm.classList.remove('login-active');
        }
        else{
            loginForm.classList.toggle('login-active');
            cart.classList.remove('cart-active');
            searchForm.classList.remove('search-active');
            navbar.classList.remove('navbar-active');
        }
    }
}

let registerForm = document.querySelector('.register-form');

document.querySelector('#register-btn').onclick = () =>{
    registerForm.classList.toggle('login-active');
    loginForm.classList.toggle('login-active');
}

document.querySelector('#register-close-btn').onclick = () =>{
    registerForm.classList.toggle('login-active');
    loginForm.classList.toggle('login-active');
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('navbar-active');
    cart.classList.remove('cart-active');
    searchForm.classList.remove('search-active');
    registerForm.classList.remove('login-active');
    loginForm.classList.remove('login-active');
}

// window.onscroll = () =>{
//     cart.classList.remove('cart-active');
//     searchForm.classList.remove('search-active');
//     registerForm.classList.remove('login-active');
//     loginForm.classList.remove('login-active');
//     navbar.classList.remove('navbar-active');
// }

let slides = document.querySelectorAll('.slide');
let index = 0;
if (document.querySelector('#next-slide') != null){
    document.querySelector('#next-slide').onclick = () =>{
        slides[index].classList.remove('slide-active');
        index = (index + 1) % 3;
        slides[index].classList.add('slide-active');
    }
    document.querySelector('#prev-slide').onclick = () =>{
        slides[index].classList.remove('slide-active');
        index = (index - 1 + 3) % 3;
        slides[index].classList.add('slide-active');
    }

    setInterval(() => {
        slides[index].classList.remove('slide-active');
        index = (index + 1) % 3;
        slides[index].classList.add('slide-active');
    }, 8000);
}

let r1 = document.querySelector('#r1');
let r2 = document.querySelector('#r2');
let a1 = document.querySelector('#a1');
let a2 = document.querySelector('#a2');

window.onload = () =>{
    if(r1 != null){
        priceFilter();
    }
}

function priceFilter(){
    if(parseInt(r1.value) > parseInt(r2.value)){
        a2.innerHTML = '₹' + r1.value;
        a1.innerHTML = '₹' + r2.value;
    }
    else if(parseInt(r1.value) < parseInt(r2.value)){
        a1.innerHTML = '₹' + r1.value;
        a2.innerHTML = '₹' + r2.value;
    }
}

let priceBtn = document.querySelector('#price-btn');
let cateBtn = document.querySelector('#cate-btn');
let priceDiv = document.querySelector('#price-filter');
let cateDiv = document.querySelector('#cate-filter');

if(priceBtn != null){
    priceBtn.onclick = () =>{
        priceDiv.classList.toggle('filter-hide-price');
    }
    cateBtn.onclick = () =>{
        cateDiv.classList.toggle('filter-hide-cate');
    }
}

function navOpen(navID){
    document.querySelector('#user-default').style.display = 'none';
    let navBoxes = document.querySelectorAll('.nav-box');
    let userBoxes = document.querySelectorAll('.user-box');
    let display = document.querySelector('#'+navID+"-box");

    if(document.querySelector('#'+navID).classList.contains('active-nav-box')){
        document.querySelector('#user-default').style.display = 'block';
        document.querySelector('#'+navID).classList.remove('active-nav-box');
        display.classList.remove('active-user-box');
    }
    else{
        for(let i = 0; i < navBoxes.length; i++){
            navBoxes[i].classList.remove('active-nav-box');
            userBoxes[i].classList.remove('active-user-box');
        }
        document.querySelector('#'+navID).classList.add('active-nav-box');
        display.classList.add('active-user-box');
    }
}


let star = document.querySelectorAll('.review-form .user .info i');
if(star != null){
    function rate(starID){
        for( let i = 0; i < star.length; i++){
            star[i].classList.add('far');
            star[i].classList.remove('fas');
        }
        let starV = starID.substring(1);
        for( let i = 0; i < starV; i++){
            star[i].classList.add('fas');
            star[i].classList.remove('far');
        }
        document.querySelector('#rating').value = starV;
    }
}

let filter = document.querySelector('#filter-form');
if(filter != null){
    filter.onchange = () => {
        document.querySelector('#filter-submit').classList.add('filter-submit-show');
    }
}

let address = document.querySelector('#address');
if(address != null){
    let addressDisplay = document.querySelector('#address-display');

    addressDisplay.innerHTML = document.querySelector('#add1').value;
    address.oninput = () => {
        addressDisplay.innerHTML = document.querySelector('#'+address.value).value;
    }
}

let payment = document.querySelector('#payment');
let paymentOption = document.querySelector('#payment-option');
if(payment != null){
    paymentOption.value = payment.value;
    payment.oninput = () => {
        paymentOption.value = payment.value;
    }
}

let orderTable = document.querySelector('.order-display table');
function disableScrolling(){
    console.log('disableScrolling');
    setTimeout(function() {
        orderTable.style.overflow = 'hidden';
    }, 2000);
}
  
function enableScrolling(){
    console.log('enable scrolling');
    orderTable.style.overflow = '';
}

document.querySelector('#search-box').oninput = () => {
    if(document.querySelector('#search-box').value== 'dogsong'){

        let divi = document.createElement('div');
        divi.style.position='absolute';
        divi.innerHTML='<img class="dog-sprite" src="lib/Annoying_Dog_Sprite.gif"> <audio src="lib/Dogsong.mp3" id="music"></audio>';
        document.querySelector('.header').appendChild(divi);
        document.getElementById('music').play();
        console.log('ye rishav ne nahi mene banaya hai');
        setTimeout(() => {
            document.querySelector('.dog-sprite').classList.add('sprite-active');
        }, 1000);

        setTimeout(() => {
            document.querySelector('.dog-sprite').classList.remove('sprite-active');
        }, 14000);
        
        setTimeout(() => {
            document.querySelector('.header').removeChild(divi);
        }, 18000);
    }
}