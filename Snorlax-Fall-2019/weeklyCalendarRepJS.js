document.getElementById("recipe-form").addEventListener("submit", function(event) {
  event.preventDefault(); // Don't attempt to post form to server.

  const recipe = document.getElementById("task").value;
  const day = document.getElementById("day").value;
  const cell = document.querySelectorAll("#t01 td")[day];

  cell.innerHTML += "<p>" + recipe + "</p>"; // Update the chosen day cell.
  document.getElementById("task").value = null; // Clear the input.
});