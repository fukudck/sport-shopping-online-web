<?php
session_start();
require_once('../../php/conn.php');
require_once('myfunctions.php');
require_once('category_functions.php');

if (isset($_POST["submit"])) {
  $name = $_POST['category_name'];
  $parentCategory = $_POST['parent_category'];
  $imgFile = $_FILES['category_image'];
  $path = "../../img/img";

  if (addCategory($conn, $name, $parentCategory, $imgFile, $path)) {
    redirect("../../dashboard-add-new-category.php", "Category added successfully");
  } else {
    redirect("../../dashboard-add-new-category.php", "Something went wrong");
  }
}
