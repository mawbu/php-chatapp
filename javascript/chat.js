const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  fileInput = document.createElement("input"),
  sendBtn = form.querySelector("button"),
  chatBox = document.querySelector(".chat-box");

// Cấu hình input file
fileInput.type = "file";
fileInput.accept = "image/*";
fileInput.style.display = "none";
form.appendChild(fileInput);

form.onsubmit = (e) => e.preventDefault();

inputField.focus();
inputField.onkeyup = () => {
  sendBtn.classList.toggle(
    "active",
    inputField.value.trim() !== "" || fileInput.files.length > 0
  );
};

// Xử lý gửi tin nhắn hoặc ảnh
sendBtn.onclick = () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/insert-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      inputField.value = "";
      fileInput.value = "";
      sendBtn.classList.remove("active");
      setTimeout(() => {
        scrollToBottom();
      }, 100);
    }
  };

  let formData = new FormData(form);
  if (fileInput.files.length > 0) {
    formData.append("file", fileInput.files[0]);
  }

  xhr.send(formData);
};

// Hiển thị input chọn ảnh khi nhấn vào icon ảnh
const attachImage = document.createElement("i");
attachImage.className = "fas fa-image attach-icon";
attachImage.style.cursor = "pointer";
attachImage.onclick = () => fileInput.click();
form.insertBefore(attachImage, inputField);

// Cập nhật CSS để căn giữa icon hình ảnh
const style = document.createElement("style");
style.innerHTML = `
  .typing-area {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    background: #f0f0f0;
    border-radius: 25px;
    width: 100%;
  }
  .attach-icon {
    font-size: 22px;
    color: #555;
    margin-right: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 45px;
    width: 45px;
  }
  .input-field {
    flex-grow: 1;
    height: 45px;
    border: none;
    outline: none;
    padding: 5px 12px;
    font-size: 16px;
    border-radius: 20px;
    background: white;
  }
`;
document.head.appendChild(style);
//
let lastMessage = "";
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/get-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let data = xhr.response;

      if (data !== lastMessage) {
        chatBox.innerHTML = data;
        lastMessage = data;

        document.querySelectorAll(".chat .chat-image").forEach((img) => {
          img.style.maxWidth = "250px";
          img.style.height = "auto";
        });

        attachImageClickEvent();

        setTimeout(() => {
          scrollToBottom();
        }, 100);
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("incoming_id=" + incoming_id);
}, 1000);

chatBox.onmouseenter = () => chatBox.classList.add("active");
chatBox.onmouseleave = () => chatBox.classList.remove("active");

function scrollToBottom() {
  requestAnimationFrame(() => {
    chatBox.scrollTop = chatBox.scrollHeight;
  });
}

//  Modal hiển thị ảnh khi click vào ảnh trong chat
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.createElement("div");
  modal.id = "imageModal";
  modal.classList.add("modal");
  modal.innerHTML = `
      <span class="close">&times;</span>
      <img class="modal-content" id="fullImage">
  `;
  document.body.appendChild(modal);

  const modalImg = document.getElementById("fullImage");
  const closeModal = modal.querySelector(".close");

  function openImageModal(src) {
    console.log("Image clicked:", src);
    modalImg.src = src;

    modal.classList.add("show");
    console.log("Modal classes:", modal.classList);
  }

  closeModal.onclick = () => {
    modal.classList.remove("show");
  };

  modal.onclick = (e) => {
    if (e.target === modal) {
      modal.classList.remove("show");
    }
  };

  // định nghĩa lại attachImageClickEvent ở phạm vi global
  window.attachImageClickEvent = function () {
    document.querySelectorAll(".chat .chat-image").forEach((img) => {
      img.onclick = () => {
        openImageModal(img.src);
      };
    });
  };

  attachImageClickEvent();
});
