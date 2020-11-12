// Προσθήκη / Αφαίρεση μαθησιακού αποτελέσματος
var items = document.querySelector("#items");
var addForm = document.getElementById("addBtn");

items.addEventListener("click", removeItem);
addForm.addEventListener("click", addItem);

// Αφαίρεση μαθησιακού αποτελέσματος
function removeItem(e) {
  console.log(e.target);
  if (e.target.classList.contains("delete-item")) {
    if (confirm("Are you sure?")) {
      var li = e.target.parentElement;
      items.removeChild(li);
    }
  }
}

// Προσθήκη μαθησιακού αποτελέσματος
function addItem(e) {
  // e.preventDefault();

  var newItem = document.getElementById("new_result").value;
  // Δημιουργία του li
  var li = document.createElement("li");
  li.className =
    "list-group-item d-flex justify-content-between align-items-center'";
  li.appendChild(document.createTextNode(newItem));

  // Δημιουργία textarea
  var textArea = document.createElement("textarea");
  textArea.setAttribute("style", "display:none");
  textArea.setAttribute("name", "course_results[]");
  textArea.appendChild(document.createTextNode(newItem));
  li.appendChild(textArea);

  // Create del button
  var deleteBtn = document.createElement("i");
  deleteBtn.className = "fas fa-trash-alt delete-item";
  li.appendChild(deleteBtn);

  items.appendChild(li);
  document.getElementById("new_result").value = "";
}

// Προσθήκη/ Αφαίρεση Βιβλιογραφίας
var newBibliography = document.querySelector("#insert_bibliography");
var newBibliographyBtn = document.querySelector("#insert_bibliography_btn");
var bookItems = document.querySelector("#bookItems");

newBibliographyBtn.addEventListener("click", addBibliography);
bookItems.addEventListener("click", removeBookItem);

function addBibliography() {
  var e = document.getElementById("insert_bibliography");
  var newBookId = e.value;
  var newBook = e.options[e.selectedIndex].text;
  console.log(newBook);
  // Δημιουργία του li
  var li = document.createElement("li");
  li.className =
    "list-group-item d-flex justify-content-between align-items-center'";
  li.appendChild(document.createTextNode(newBook));

  // Δημιουργία textarea
  var textArea = document.createElement("textArea");
  textArea.setAttribute("style", "display:none");
  textArea.setAttribute("name", "books_update[]");
  textArea.appendChild(document.createTextNode(newBookId));
  li.appendChild(textArea);

  // Create del button
  var deleteBtn = document.createElement("i");
  deleteBtn.className = "fas fa-trash-alt delete-item";
  li.appendChild(deleteBtn);

  bookItems.appendChild(li);
}

// Αφαίρεση Βιβλίου από Βιβλιογραφία
function removeBookItem(e) {
  console.log(e.target);
  if (e.target.classList.contains("delete-item")) {
    if (
      confirm(
        "Είστε σίγουρος ότι θέλετε να αφαιρέσετε το βιβλίο από τη λίστα συγγραμμάτων;"
      )
    ) {
      var li = e.target.parentElement;
      bookItems.removeChild(li);
    }
  }
}

// Προσθήκη Μαθήματος στα προαπαιτούμενα

var insertPrereqLessonBtn = document.querySelector("#insert_prereq_lesson_btn");
var alphaTeamList = document.querySelector("#alpha_team");
var betaTeamList = document.querySelector("#beta_team");
// var teamLists = document.querySelector(".team_lists");

insertPrereqLessonBtn.addEventListener("click", addPrereqLesson);
alphaTeamList.addEventListener("click", removeFromGroupA);
betaTeamList.addEventListener("click", removeFromGroupB);

function addPrereqLesson() {
  var prereqLesson = document.querySelector("#prereq_lesson").value;
  var group = document.querySelector("#group").value;
  console.log(prereqLesson);
  var e = document.querySelector("#prereq_lesson");
  var lessonId = e.value;
  var lesson = e.options[e.selectedIndex].text;
  // Δημιουργία του li
  var li = document.createElement("li");
  li.className =
    "list-group-item d-flex justify-content-between align-items-center'";
  li.appendChild(document.createTextNode(lesson));

  // Δημιουργία input
  var input = document.createElement("input");
  input.setAttribute("style", "display:none");
  if (group == 0) input.setAttribute("name", "group_a_lessons[]");
  else input.setAttribute("name", "group_b_lessons[]");
  input.setAttribute("value", prereqLesson);

  input.appendChild(document.createTextNode(lessonId));
  li.appendChild(input);

  // Create del button
  var deleteBtn = document.createElement("i");
  deleteBtn.className = "fas fa-trash-alt delete-item";
  li.appendChild(deleteBtn);

  if (group == 0) {
    alphaTeamList.appendChild(li);
  } else {
    betaTeamList.appendChild(li);
  }
}

// Αφαίρεση Βιβλίου από Βιβλιογραφία
function removeFromGroupA(e) {
  console.log(e.target);
  if (e.target.classList.contains("delete-item")) {
    if (
      confirm(
        "Είστε σίγουρος ότι θέλετε να αφαιρέσετε το βιβλίο από τη λίστα συγγραμμάτων;"
      )
    ) {
      var li = e.target.parentElement;
      alphaTeamList.removeChild(li);
    }
  }
}

// Αφαίρεση Βιβλίου από Βιβλιογραφία
function removeFromGroupB(e) {
  console.log(e.target);
  if (e.target.classList.contains("delete-item")) {
    if (
      confirm(
        "Είστε σίγουρος ότι θέλετε να αφαιρέσετε το βιβλίο από τη λίστα συγγραμμάτων;"
      )
    ) {
      var li = e.target.parentElement;
      betaTeamList.removeChild(li);
    }
  }
}
