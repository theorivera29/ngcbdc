# bootstrap-left-slide-menu
Simple Bootstrap (Left) Slide Menu

https://jsfiddle.net/fragcoder/knkd8q1g/

USAGE:
  ```
  <html>
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TITLE</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
      <link rel="stylesheet" href="https://rawgit.com/FragCoder/bootstrap-left-slide-menu/master/bootstrap-left-slide-menu.css">
   </head>
   <body>
      <div id="wrapper" class="">
         <div class="overlay" style="display: none;"></div>
         <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
               <li class="sidebar-brand">
                  <a href="#"> BLESM </a>
               </li>
               <li>
                  <a href="#"><i class="glyphicon glyphicon-camera"></i> Photo</a>
               </li>
               <li>
                  <a href="#"><i class="glyphicon glyphicon-facetime-video"></i> Video</a>
               </li>
               <li>
                  <a href="#"><i class="glyphicon glyphicon-headphones"></i> Music</a>
               </li>
               <li>
                  <a href="#"><i class="glyphicon glyphicon-cloud"></i> Cloud</a>
               </li>
               <li>
                  <a href="#"><i class="glyphicon glyphicon-th"></i> Apps</a>
               </li>
               <li>
                  <a href="#"><i class="glyphicon glyphicon-cog"></i> Settings</a>
               </li>
            </ul>
         </nav>
         <div id="page-content-wrapper">
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
            </button>
            <div class="container">
               ...YOUR CONTENT...
            </div>
         </div>
      </div>
      <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="https://rawgit.com/FragCoder/bootstrap-left-slide-menu/master/bootstrap-left-slide-menu.js"></script>
   </body>
</html>
```
