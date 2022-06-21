const classInput = document.getElementById("classInput");
const addButton = document.getElementById("add");
const myCourses = document.getElementById("myCourses");

let inputedClass = "";

// listen event for class input
// classInput.addEventListener("keyup", (event) => {
//   if (event.key === "Backspace") {
//     inputedClass = inputedClass.slice(0, -1);
//   } else {
//     inputedClass = inputedClass + event.key;
//   }
// });

// addButton.addEventListener("click", (event) => {
//   if (inputedClass.length > 0) {
//     const newClass = `<li>
//                 <input type="checkbox" name="${inputedClass.toUpperCase()}" id="${inputedClass.toUpperCase()}">
//                 <label for="${inputedClass.toUpperCase()}">${inputedClass.toUpperCase()}</label>
//                 <span class="delete"></span>
//             </li>`;
//     classInput.value = "";
//     myCourses.innerHTML += newClass;
//     inputedClass = "";
//   }
// });

document.addEventListener("click", (event) => {
  if (event.target.classList.contains("delete")) {
    const deleteClass = event.target.parentNode;
    // deleteClass.remove();
  }

  if (event.target.type === "checkbox") {
    // sumbit form to update course to complete
    event.target.closest("form").submit();
  }
});

document.addEventListener("auxclick", (event) => {
  console.log(event.cancelable);

  if (event.target.nodeName === "LABEL") {
    const inputNode = document.createElement("INPUT");
    event.target.appendChild(inputNode);
  }
});

document.addEventListener("contextmenu", (event) => {
  event.preventDefault();
});
