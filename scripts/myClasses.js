document.addEventListener("click", (event) => {
  if (event.target.type === "checkbox") {
    // sumbit form to update course to complete
    event.target.closest("form").submit();
  }

  if (event.target.classList.contains("edit")) {
    const input = document.createElement("input");
    input.setAttribute("name", "edited");
    input.setAttribute("class", "edited");
    input.setAttribute("value", event.target.innerText);

    const original = document.createElement("input");
    original.setAttribute("type", "hidden");
    original.setAttribute("name", "original");
    original.setAttribute("value", event.target.innerText);

    // replace p with input
    event.target.replaceWith(input, original);
    input.focus();

    updateCourse = input;
  }

  // console.log(event);
});

// when click out of input
document.addEventListener("focusout", (event) => {
  if (event.target.classList.contains("edited"))
    event.target.closest("form").submit();
});
