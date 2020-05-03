<?php
$pagecode=   "document.getElementById(\"recipe-form\").addEventListener(\"submit\", function(event) {
  event.preventDefault();

  const recipe = document.getElementById(\"task\").value;
  const day = document.getElementById(\"day\").value;
  const cell = document.querySelectorAll(\"#t01 td\")[day];

  cell.innerHTML += \"<p>\" + recipe + \"</p>\"; 
  document.getElementById(\"task\").value = null; 
});\n";

echo "$pagecode";
?>