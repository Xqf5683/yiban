<!doctype html>
<html class="no-js" lang="" xmlns="http://www.w3.org/1/xhtml"
      xmlns:th="http://www.thymeleaf.org">
<head>
  <meta charset="utf-8">
  <title>请确认您的位置</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">

  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <!-- <base href="{base_url()}/yiban"> -->
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<!-- Buttons 库的核心文件 -->
<link rel="stylesheet" href="<?php echo base_url() ;?>css/data/buttons.css">
  <!-- build:css(.) styles/vendor.css -->
  <!-- bower:css -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap/dist/css/bootstrap.css" />
  <!-- endbower -->
  <!-- endbuild -->
  <!-- build:css(.tmp) styles/main.css -->
  <link rel="stylesheet" href="<?php echo base_url();?>/css/qiandao/main.css">
  <!-- endbuild -->
  <!-- build:js scripts/vendor/modernizr.js -->
  <script src="<?php echo base_url();?>/bower_components/modernizr/modernizr.js"></script>
  <!-- endbuild -->

</head>
<body onload="geolocation.getLocation(showPosition, showErr, options);">

<div class="container">

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">中南大学易签到</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">首页</a></li>
          <li><a href="#">关于</a></li>
          <li><a href="<?php echo base_url();?>Chat">联系我们</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </nav>
