<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/admin/header.css">
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Barlow', sans-serif;
}
.header-container{
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 1300px;
    height: 60px;
    margin: auto;
}
.header .brand{
    width: 20%;
    display: flex;
    justify-content: start;
    align-items: center;
}
.header .brand img{
    width: 15%;
    margin-right: 5px;
}
.header .brand .logo{
    color: #FF7200;
    font-weight: bold;
    letter-spacing: 1px;
    font-size: 1.8em;
}
.header .menu{
    display: flex;
    justify-content: space-between;
    align-items: center ;
    width: 80%;
    background: #fff;
    box-shadow: 0 5px 5px #c6c6c6;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    height: 100%;
}
.header .search{
    width: 80%;
    display: flex;
    justify-content: start;
    align-items: center;
    margin-left: 15px;
    position: relative;
}
.header .menu .search input{
    width: 100%;
    height: 35px;
    border-radius: 10px;
    border: 1px solid #ebebeb;
}
.header .search button{
    width: 30px;
    height: 30px;
    border-radius: 10px;
    background-image: linear-gradient(to bottom right,#d86100,#FF7200,#ff8c2d);
    border: none;
    position: absolute;
    right: -10px;
    top: -10px;
}
.header .search ion-icon{
    font-size: 20px;
}
.header .menu .action{
    display: flex;
    justify-content: end;
    align-items: center; 
    width: 20%;
    margin-right: 15px;
}
.header .action img{
    width: 100%;
    border-radius: 50%;
    border: 1px solid #ebebeb;
}
.header .action a:first-child{
    width: 20%;
}
.header .action a:last-child{
    margin-left: 10px;
}
.header .action ion-icon{
    font-size: 20px;
    color: #000;
}
</style>
<body>
    <div class="header">
        <div class="header-container">
            <div class="brand">
                <img src="../Uploads/Logo/logo.png" alt="">
                <p class="logo">Hyper<br>Store</p>
            </div>
            <div class="menu">
                <form action="#" class="search">
                    <input type="text" placeholder="Type here...">
                    <button><ion-icon name="search-outline"></ion-icon></button>
                </form>
                <div class="action">
                    <a href="#"><img src="../Uploads/User/nam.jpg" alt=""></a>
                    <!-- <a href="#"><ion-icon name="cart-outline"></ion-icon></a> -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>