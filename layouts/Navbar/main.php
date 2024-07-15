<?php
session_start();
// Default name if not logged in
$name = "Not Loggin";

// Gunakan __DIR__ untuk jalur absolut
include(__DIR__ . '/../../allkoneksi/koneksi.php');

// Fetch user's name if logged in
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $query = "SELECT name FROM users WHERE username = '$username'";
  $result = mysqli_query($koneksi, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
  }
}
?>

<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hoverable Sidebar Menu HTML CSS & JavaScript</title>
  <!-- <link rel="stylesheet" href="styles.css" /> -->
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!-- <script src="index.js" defer></script> -->
</head>

<body>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      min-height: 100vh;
      background: #eef5fe;
    }

    /* Pre css */
    .flex {
      display: flex;
      align-items: center;
    }

    .nav_image {
      display: flex;
      min-width: 55px;
      justify-content: center;
    }

    .nav_image img {
      height: 35px;
      width: 35px;
      border-radius: 50%;
      object-fit: cover;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 270px;
      background: #fff;
      padding: 15px 10px;
      box-shadow: 0 0 2px rgba(0, 0, 0, 0.1);
      transition: all 0.4s ease;
    }

    .sidebar.close {
      width: calc(55px + 20px);
    }

    .logo_items {
      gap: 8px;
    }

    .logo_name {
      font-size: 22px;
      color: #333;
      font-weight: 500px;
      transition: all 0.3s ease;
    }

    .sidebar.close .logo_name,
    .sidebar.close #lock-icon,
    .sidebar.close #sidebar-close {
      opacity: 0;
      pointer-events: none;
    }

    #lock-icon,
    #sidebar-close {
      padding: 10px;
      color: #4070f4;
      font-size: 25px;
      cursor: pointer;
      margin-left: -4px;
      transition: all 0.3s ease;
    }

    #sidebar-close {
      display: none;
      color: #333;
    }

    .menu_container {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      margin-top: 40px;
      overflow-y: auto;
      height: calc(100% - 82px);
    }

    .menu_container::-webkit-scrollbar {
      display: none;
    }

    .menu_title {
      position: relative;
      height: 50px;
      width: 55px;
    }

    .menu_title .title {
      margin-left: 15px;
      transition: all 0.3s ease;
    }

    .sidebar.close .title {
      opacity: 0;
    }

    .menu_title .line {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      height: 3px;
      width: 20px;
      border-radius: 25px;
      background: #aaa;
      transition: all 0.3s ease;
    }

    .menu_title .line {
      opacity: 0;
    }

    .sidebar.close .line {
      opacity: 1;
    }

    .item {
      list-style: none;
    }

    .link {
      text-decoration: none;
      border-radius: 8px;
      margin-bottom: 8px;
      color: #707070;
    }

    .link:hover {
      color: #fff;
      background-color: #4070f4;
    }

    .link span {
      white-space: nowrap;
    }

    .link i {
      height: 50px;
      min-width: 55px;
      display: flex;
      font-size: 22px;
      align-items: center;
      justify-content: center;
      border-radius: 4px;
    }

    .sidebar_profile {
      padding-top: 15px;
      margin-top: 15px;
      gap: 15px;
      border-top: 2px solid rgba(0, 0, 0, 0.1);
    }

    .sidebar_profile .name {
      font-size: 18px;
      color: #333;
    }

    .sidebar_profile .username {
      position: relative;
      font-size: 15px;
      color: #333;
    }

    /* Navbar */
    .navbar {
      max-width: 500px;
      width: 100%;
      position: fixed;
      top: 0;
      left: 60%;
      transform: translateX(-50%);
      background: #fff;
      padding: 10px 20px;
      border-radius: 0 0 8px 8px;
      justify-content: space-between;
    }

    #sidebar-open {
      font-size: 30px;
      color: #333;
      cursor: pointer;
      margin-right: 20px;
      display: none;
    }

    .search_box {
      height: 46px;
      max-width: 500px;
      width: 100%;
      border: 1px solid #aaa;
      outline: none;
      border-radius: 8px;
      padding: 0 15px;
      font-size: 18px;
      color: #333;
    }

    .navbar img {
      height: 40px;
      width: 40px;
      margin-left: 20px;
    }

    /* Responsive */
    @media screen and (max-width: 1100px) {
      .navbar {
        left: 65%;
      }
    }

    @media screen and (max-width: 800px) {
      .sidebar {
        left: 0;
        z-index: 1000;
      }

      .sidebar.close {
        left: -100%;
      }

      #sidebar-close {
        display: block;
      }

      #lock-icon {
        display: none;
      }

      .navbar {
        left: 0;
        max-width: 100%;
        transform: translateX(0%);
      }

      #sidebar-open {
        display: block;
      }
    }

    /* Style untuk dropdown */
    .profile-dropdown {
      position: relative;
      display: inline-block;
    }

    .profile-dropdown .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
      border-radius: 5px;
    }

    .profile-dropdown .dropdown-content a {
      color: black;
      padding: 15px 19px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid #e1e1e1;
    }

    .profile-dropdown .dropdown-content a:last-child {
      border-bottom: none;
    }

    .profile-dropdown .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .profile-dropdown:hover .dropdown-content {
      display: block;
    }
  </style>
  <nav class="sidebar locked">
    <div class="logo_items flex">
      <span class="nav_image">
        <!-- <img src="images/logo.png" alt="logo_img" /> -->
      </span>
      <span class="logo_name">CodingNepal</span>
      <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
      <i class="bx bx-x" id="sidebar-close"></i>
    </div>

    <div class="menu_container">
      <div class="menu_items">
        <ul class="menu_item">
          <div class="menu_title flex">
            <span class="title">Dashboard</span>
            <span class="line"></span>
          </div>
          <li class="item">
            <a href="../../Admin/index.php" class="link flex">
              <i class="bx bx-home-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
        </ul>

        <ul class="menu_item">
          <div class="menu_title flex">
            <span class="title">Editor</span>
            <span class="line"></span>
          </div>
          <li class="item">
            <a href="#" class="link flex">
              <i class="bx bx-cloud-upload"></i>
              <span>Upload New</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="sidebar_profile flex">
        <span class="nav_image">
          <img src="images/profile.jpg" alt="logo_img" />
        </span>
        <div class="data_text">
          <span class="name"><?php echo $name ?></span>
          <span class="username">@<?php echo $username ?></span>
        </div>
      </div>
    </div>
  </nav>

  <!-- Navbar -->

</body>

</html>
<!-- scirp -->
<script>
  // Selecting the sidebar and buttons
  const sidebar = document.querySelector(".sidebar");
  const sidebarOpenBtn = document.querySelector("#sidebar-open");
  const sidebarCloseBtn = document.querySelector("#sidebar-close");
  const sidebarLockBtn = document.querySelector("#lock-icon");

  // Function to toggle the lock state of the sidebar
  const toggleLock = () => {
    sidebar.classList.toggle("locked");
    // If the sidebar is not locked
    if (!sidebar.classList.contains("locked")) {
      sidebar.classList.add("hoverable");
      sidebarLockBtn.classList.replace("bx-lock-alt", "bx-lock-open-alt");
    } else {
      sidebar.classList.remove("hoverable");
      sidebarLockBtn.classList.replace("bx-lock-open-alt", "bx-lock-alt");
    }
  };

  // Function to hide the sidebar when the mouse leaves
  const hideSidebar = () => {
    if (sidebar.classList.contains("hoverable")) {
      sidebar.classList.add("close");
    }
  };

  // Function to show the sidebar when the mouse enter
  const showSidebar = () => {
    if (sidebar.classList.contains("hoverable")) {
      sidebar.classList.remove("close");
    }
  };

  // Function to show and hide the sidebar
  const toggleSidebar = () => {
    sidebar.classList.toggle("close");
  };

  // If the window width is less than 800px, close the sidebar and remove hoverability and lock
  if (window.innerWidth < 800) {
    sidebar.classList.add("close");
    sidebar.classList.remove("locked");
    sidebar.classList.remove("hoverable");
  }

  // Adding event listeners to buttons and sidebar for the corresponding actions
  sidebarLockBtn.addEventListener("click", toggleLock);
  sidebar.addEventListener("mouseleave", hideSidebar);
  sidebar.addEventListener("mouseenter", showSidebar);
  sidebarOpenBtn.addEventListener("click", toggleSidebar);
  sidebarCloseBtn.addEventListener("click", toggleSidebar);

  // profile
  // Mengatur dropdown untuk profil
  document
    .querySelector(".profile-dropdown")
    .addEventListener("click", function(event) {
      event.stopPropagation();
      this.querySelector(".dropdown-content").classList.toggle("show");
    });

  // Menutup dropdown ketika klik di luar elemen dropdown
  window.onclick = function(event) {
    if (!event.target.matches(".profile-dropdown, .profile-dropdown *")) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
</script>