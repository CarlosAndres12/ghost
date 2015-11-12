<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--<link rel="shortcut icon" href="{$gvar.l_global}favicon.ico" />-->
  <title>{$title}</title>
  {literal} 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style type="text/css"> @import url({/literal}{$gvar.l_global}{literal}css/materialize.css); </style>
    <style type="text/css"> @import url({/literal}{$gvar.l_global}{literal}css/general.css); </style>
    <script type='text/javascript'>l_global = '{/literal}{$gvar.l_global}{literal}';</script>
    <script src="{/literal}{$gvar.l_global}{literal}js/jquery-1.7.2.min.js" language="Javascript"></script>
    <script src="{/literal}{$gvar.l_global}{literal}js/materialize.js" language="Javascript"></script>
    <script src="{/literal}{$gvar.l_global}{literal}js/general.js" language="Javascript"></script>
  {/literal}
</head>
<body>
<nav class="blue darken-4">

<a href="{$gvar.l_global}" class="brand-logo">Ghost</a>
  <ul id="nav-mobile" class="right hide-on-med-and-down">
    {if isset($smarty.session.nombre_usuario) && $smarty.get.option neq 'logout'}
      <li><a href="{$gvar.l_global}login.php?option=logout">{$gvar.n_logout}</a></li>
    {else}
      <li><a href="{$gvar.l_global}login.php">{$gvar.n_login}</a></li>
    {/if}
  </ul>
<ul id="slide-out" class="side-nav">
    {if isset($smarty.session.nombre_usuario) && $smarty.get.option neq 'logout'}
      <li><a href="{$gvar.l_global}login.php?option=logout">{$gvar.n_logout}</a></li>
    {else}
      <li><a href="{$gvar.l_global}login.php">{$gvar.n_login}</a></li>
    {/if}
  </ul>
  <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
</nav>

<div id="content" class="container"> 