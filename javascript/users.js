const searchBar = document.querySelector(".search input"),
  searchIcon = document.querySelector(".search button"),
  usersList = document.querySelector(".users-list");

searchIcon.onclick = () => {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/search.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        usersList.innerHTML = data;
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "../php/users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
        }
      }
    }
  };
  xhr.send();
}, 500);

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "../php/users.php", true);
  xhr.onload = () => {
    if (xhr.status === 200) {
      let data = xhr.responseText;
      document.querySelector(".users-list").innerHTML = data;

      // Cập nhật trạng thái của chính user
      let currentStatus = document.querySelector(".details p");
      let selfStatus = document.querySelector("#self-status");
      if (selfStatus) {
        currentStatus.textContent = selfStatus.dataset.status; // Lấy trạng thái từ thẻ hidden
      }
    }
  };
  xhr.send();
}, 500); // Cập nhật mỗi 5 giây

window.addEventListener("beforeunload", () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/logout.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("auto_logout=true");
});
