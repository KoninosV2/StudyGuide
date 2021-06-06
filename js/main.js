// Προσθήκη / Αφαίρεση μαθησιακού αποτελέσματος
const items = document.querySelector("#items");
const addForm = document.getElementById("addBtn");
if (items) {
  items.addEventListener("click", removeItem);
}

if (addForm) {
  addForm.addEventListener("click", addItem);
}

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
    "list-group-item d-flex justify-content-between align-items-center";
  li.appendChild(document.createTextNode(newItem));

  // Δημιουργία textarea
  var textArea = document.createElement("textarea");
  textArea.setAttribute("style", "display:none");
  textArea.setAttribute("name", "course_results[]");
  textArea.appendChild(document.createTextNode(newItem));
  li.appendChild(textArea);

  // Create del button
  var deleteBtn = document.createElement("i");
  deleteBtn.className = "fas fa-trash-alt delete-item ml-3";
  li.appendChild(deleteBtn);

  items.appendChild(li);
  document.getElementById("new_result").value = "";
}

// Προσθήκη/ Αφαίρεση Βιβλιογραφίας
var newBibliography = document.querySelector("#insert_bibliography");
var newBibliographyBtn = document.querySelector("#insert_bibliography_btn");
var bookItems = document.querySelector("#bookItems");
if (newBibliography) {
  newBibliographyBtn.addEventListener("click", function () {
    const books = Array.from(bookItems.children);
    const newBook = document.querySelector("#insert_bibliography").value;
    const errorMsg = document.querySelector(".error-bibliography");
    let book_exists = false;
    for (let i = 0; i < books.length; i++) {
      if (books[i].children[0].value === newBook) {
        book_exists = true;
        break;
      }
    }
    if (!book_exists) {
      addBibliography();
    } else {
      errorMsg.style.display = "block";
      setTimeout(function () {
        errorMsg.style.display = "none";
      }, 3000);
    }
  });
}

if (bookItems) {
  bookItems.addEventListener("click", removeBookItem);
}

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

document.addEventListener("DOMContentLoaded", showPrereqCourses);

function showPrereqCourses() {
  const prereqCourses = document.querySelector("#prerequired-courses");
  const groupA = document.querySelector("#group-a");
  let groupACourses = "";
  for (let course = 0; course < alphaTeamList.children.length; course++) {
    if (course < alphaTeamList.children.length - 1) {
      groupACourses += alphaTeamList.children[course].firstChild.nodeValue;
      groupACourses += " ή ";
    } else {
      groupACourses += alphaTeamList.children[course].firstChild.nodeValue;
    }
  }
  groupA.innerHTML = "(" + groupACourses + ")";

  const groupB = document.querySelector("#group-b");
  let groupBCourses = "";
  for (let course = 0; course < betaTeamList.children.length; course++) {
    if (course < betaTeamList.children.length - 1) {
      groupBCourses += betaTeamList.children[course].firstChild.nodeValue;
      groupBCourses += " ή ";
    } else {
      groupBCourses += betaTeamList.children[course].firstChild.nodeValue;
    }
  }
  if (groupBCourses) {
    groupB.innerHTML = " ΚΑΙ " + "(" + groupBCourses + ")";
  }
}

if (insertPrereqLessonBtn) {
  insertPrereqLessonBtn.addEventListener("click", function () {
    const listItemsAlpha = Array.from(alphaTeamList.children);
    const listItemsBeta = Array.from(betaTeamList.children);
    const totalListItems = listItemsAlpha.concat(listItemsBeta);
    const prereqLesson = document.querySelector("#prereq_lesson").value;
    const errorMessage = document.querySelector(".error-lesson");
    let lesson_exists = false;
    for (let i = 0; i < totalListItems.length; i++) {
      if (totalListItems[i].children[0].value === prereqLesson) {
        lesson_exists = true;
        break;
      }
    }
    if (!lesson_exists) {
      addPrereqLesson();
      showPrereqCourses();
    } else {
      errorMessage.style.display = "block";
      setTimeout(function () {
        errorMessage.style.display = "none";
      }, 3000);
    }
  });
}

if (alphaTeamList) {
  alphaTeamList.addEventListener("click", removeFromGroupA);
}

if (betaTeamList) {
  betaTeamList.addEventListener("click", removeFromGroupB);
}

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

// Αφαίρεση Μαθήματος από Βιβλιογραφία
function removeFromGroupA(e) {
  console.log(e.target);
  if (e.target.classList.contains("delete-item")) {
    if (
      confirm(
        "Είστε σίγουρος ότι θέλετε να αφαιρέσετε το συγκεκριμένο μάθημα από την λίστα;"
      )
    ) {
      var li = e.target.parentElement;
      alphaTeamList.removeChild(li);
      showPrereqCourses();
    }
  }
}

// Αφαίρεση Μαθήματος από Βιβλιογραφία
function removeFromGroupB(e) {
  console.log(e.target);
  if (e.target.classList.contains("delete-item")) {
    if (
      confirm(
        "Είστε σίγουρος ότι θέλετε να αφαιρέσετε το συγκεκριμένο μάθημα από την λίστα;"
      )
    ) {
      var li = e.target.parentElement;
      betaTeamList.removeChild(li);
    }
  }
}

// ΟΡΓΑΝΩΣΗ ΔΙΔΑΣΚΑΛΙΑΣ
// Ενημέρωση συνολικών ωρών διδασκαλίας του μαθήματος
const inputs = document.querySelectorAll(".organize-teaching");
const totalHoursUI = document.querySelector("#total-hours");
inputs.forEach(function (input) {
  input.addEventListener("blur", calculateTotalHours);
});

function calculateTotalHours() {
  let totalHours = 0;
  inputs.forEach(function (input) {
    if (parseInt(input.value)) totalHours += parseInt(input.value);
  });
  totalHoursUI.innerHTML = totalHours;
  console.log(totalHours);
  console.log(typeof totalHours);
}

// FORM VALIDATION

function showMessage(object, msg) {
  object.children[0].textContent = msg;
  object.style.display = "block";
  setTimeout(function () {
    object.style.display = "none";
  }, 3000);
}

function isEmpty(inputs) {
  let emptyInputs = false;
  inputs.forEach(function (input) {
    if (input.children[1].value === "") {
      emptyInputs = true;
    }
  });
  return emptyInputs;
}

function alreadyExists(elementList, elem, index) {
  let exist = false;
  elementList.forEach(function (element) {
    if (element.children[index].textContent === elem) {
      exist = true;
    }
  });
  return exist;
}

function changeBorderColor() {
  const resetBtn = document.querySelector('input[type="reset"]');
  // Input Fields
  if (document.querySelectorAll("input")) {
    const inputs = document.querySelectorAll("input");
    const inputsArray = Array.from(inputs);
    let inputsPrevValues = inputsArray.map((input) => input.value);
    for (let i = 0; i < inputs.length; i++) {
      inputs[i].addEventListener("change", function () {
        if (inputs[i].value != inputsPrevValues[i]) {
          inputs[i].style.borderColor = "#FFC107";
        }
        if (inputs[i].value == inputsPrevValues[i]) {
          inputs[i].style.borderColor = "#D1D3E2";
        }
      });
    }
  }

  // Select Fields
  if (document.querySelectorAll("select")) {
    const selects = document.querySelectorAll("select");
    const selectsArray = Array.from(selects);
    const selectsPrevValues = selectsArray.map((input) => input.value);
    for (let i = 0; i < selects.length; i++) {
      selects[i].addEventListener("change", () => {
        if (selects[i].value != selectsPrevValues[i]) {
          selects[i].style.borderColor = "#FFC107";
        } else {
          selects[i].style.borderColor = "#D1D3E2";
        }
      });
    }
  }

  // Textarea Fields
  if (document.querySelectorAll("textarea")) {
    const textareas = document.querySelectorAll("textarea");
    const textareaArray = Array.from(textareas);
    const textareasPrevValues = textareaArray.map((input) => input.value);
    for (let i = 0; i < textareas.length; i++) {
      textareas[i].addEventListener("change", () => {
        if (textareas[i].value != textareasPrevValues[i]) {
          textareas[i].style.borderColor = "#FFC107";
        } else {
          textareas[i].style.borderColor = "#D1D3E2";
        }
      });
    }
  }

  // Checkboxes
  if (document.querySelectorAll('input[type="checkbox"]')) {
    const boxes = document.querySelectorAll('input[type="checkbox"]');
    const boxesArray = Array.from(boxes);
    const boxesPrevValues = boxesArray.map((input) => input.checked);
    for (let i = 0; i < boxes.length; i++) {
      boxes[i].addEventListener("change", (e) => {
        if (boxesPrevValues[i] == false) {
          e.target.nextElementSibling.style.color = e.target.checked
            ? "blue"
            : "#858796";
        } else {
          e.target.nextElementSibling.style.color = e.target.checked
            ? "#858796"
            : "blue";
        }
      });
    }
  }

  resetBtn.addEventListener("click", (e) => {
    // Input Fields
    if (document.querySelectorAll("input")) {
      const inputs = document.querySelectorAll("input");
      for (let i = 0; i < inputs.length; i++) {
        inputs[i].style.borderColor = "#D1D3E2";
      }
    }
    // Select Fields
    if (document.querySelectorAll("select")) {
      const selects = document.querySelectorAll("select");
      for (let i = 0; i < selects.length; i++) {
        selects[i].style.borderColor = "#D1D3E2";
      }
    }
    // Textarea Fields
    if (document.querySelectorAll("textarea")) {
      const textareas = document.querySelectorAll("textarea");
      for (let i = 0; i < textareas.length; i++) {
        textareas[i].style.borderColor = "#D1D3E2";
      }
    }
  });
}

// Eισαγωγή κατηγορίας μαθήματος
if ((newCategoryForm = document.getElementById("new-category-form"))) {
  newCategoryForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-lesson-category");
    const lessonCategories = document.querySelectorAll("table tbody tr");
    const required = document.querySelectorAll(".required");
    let dataOk = true;
    console.log(required[1].children[1].value);

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (alreadyExists(lessonCategories, required[1].children[1].value, 1)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει κατηγορία με κωδικό ${required[1].children[1].value}`
      );
      dataOk = false;
    }

    if (alreadyExists(lessonCategories, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει κατηγορία με α/α ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Validation φόρμας τροποποίησης
if ((editCategoriesForm = document.querySelector("#edit-categories-form"))) {
  editCategoriesForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-edit-categories");
    const required = document.querySelectorAll(".required");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit();
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  // const inputs = document.querySelectorAll("input");
  // const inputsArray = Array.from(inputs);
  // let inputsPrevValues = inputsArray.map((input) => input.value);
  changeBorderColor();
}

// Εισαγωγή τύπου μαθήματος
if ((newTypeForm = document.querySelector("#new-type-form"))) {
  newTypeForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-lesson-type");
    const lessonTypes = document.querySelectorAll("table tbody tr");
    const maxLengthId = 7;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (alreadyExists(lessonTypes, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει κατηγορία με κωδικό ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (required[0].children[1].value.length > maxLengthId) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων 7.`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Τροποποίηση Τύπου Μαθήματος
if ((updateTypesForm = document.querySelector("#update-lesson-type"))) {
  updateTypesForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-lesson-type-update");
    const required = document.querySelectorAll(".required");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });

  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΤΡΟΠΟΙ ΠΑΡΑΔΟΣΗΣ ΜΑΘΗΜΑΤΟΣ
// Validation φόρμας εισαγωγής
if (
  (newWhereTeachingForm = document.querySelector("#new-where-teaching-form"))
) {
  newWhereTeachingForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-lesson-where-teaching");
    const whereCodes = document.querySelectorAll("table tbody tr");
    const maxLength = 9;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[0].children[1].value.length > maxLength) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLength}.`
      );
      dataOk = false;
    }

    if (alreadyExists(whereCodes, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με κωδικό ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Vallidation φόρμας τροποποίησης
if ((updateWhereTeachingForm = document.querySelector("#update-where-form"))) {
  updateWhereTeachingForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-lesson-where-teaching-update");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΑΠΟΚΤΟΜΕΝΕΣ ΙΚΑΝΟΤΗΤΕΣ
// Validation φόρμας εισαγωγής
if ((newAbilityForm = document.querySelector("#new-ability-form"))) {
  newAbilityForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-new-ability");
    const abilityCodes = document.querySelectorAll("table tbody tr");
    const maxLength = 11;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[1].children[1].value.length > maxLength) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLength}.`
      );
      dataOk = false;
    }

    if (alreadyExists(abilityCodes, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με α/α ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (alreadyExists(abilityCodes, required[1].children[1].value, 1)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με κωδικό ${required[1].children[1].value}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Validation φόρμας τροποποίησης
if ((updateAbilityForm = document.querySelector("#update-ability-form"))) {
  updateAbilityForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-update-ability");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΜΕΘΟΔΟΙ ΑΞΙΟΛΟΓΗΣΗΣ
// Validation φόρμας εισαγωγής
if ((newAssessmentForm = document.querySelector("#new-assessment-form"))) {
  newAssessmentForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-new-assessment");
    const assessments = document.querySelectorAll("table tbody tr");
    const maxLength = 7;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[1].children[1].value.length > maxLength) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLength}.`
      );
      dataOk = false;
    }

    if (alreadyExists(assessments, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με α/α ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (alreadyExists(assessments, required[1].children[1].value, 1)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με κωδικό ${required[1].children[1].value}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Validation φόρμας τροποποίησης
if (
  (updateAssessmentForm = document.querySelector("#update-assessment-form"))
) {
  updateAssessmentForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-update-assessment");
    const required = document.querySelectorAll(".required");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΜΕΘΟΔΟΙ ΔΙΔΑΣΚΑΛΙΑΣ
// Validation φόρμας εισαγωγής
if (
  (newTeachingMethodForm = document.querySelector("#new-teaching-method-form"))
) {
  newTeachingMethodForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-new-teaching-methods");
    const required = document.querySelectorAll(".required");
    const teachingMethods = document.querySelectorAll("table tbody tr");
    const maxLength = 7;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[1].children[1].value.length > maxLength) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLength}.`
      );
      dataOk = false;
    }

    if (alreadyExists(teachingMethods, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με α/α ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (alreadyExists(teachingMethods, required[1].children[1].value, 1)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με κωδικό ${required[1].children[1].value}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

if (
  (updateTeachingMethodsForm = document.querySelector(
    "#update-teaching-methods-form"
  ))
) {
  updateTeachingMethodsForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-update-teaching-methods");
    const required = document.querySelectorAll(".required");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΤΕΧΝΟΛΟΓΙΕΣ ΔΙΔΑΣΚΑΛΙΑΣ
// Validation φόρμας εισαγωγής
if ((newTechMethodsForm = document.querySelector("#new-tech-methods-form"))) {
  newTechMethodsForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-new-tech-methods");
    const required = document.querySelectorAll(".required");
    const techMethods = document.querySelectorAll("table tbody tr");
    const maxLength = 7;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[1].children[1].value.length > maxLength) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLength}.`
      );
      dataOk = false;
    }

    if (alreadyExists(techMethods, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με α/α ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (alreadyExists(techMethods, required[1].children[1].value, 1)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με κωδικό ${required[1].children[1].value}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Validate φόρμα τροποποίησης
if (
  (updateTechMethodsForm = document.querySelector("#update-tech-methods-form"))
) {
  updateTechMethodsForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-update-tech-methods");
    const required = document.querySelectorAll(".required");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΒΙΒΛΙΟΓΡΑΦΙΑ
// Validation φόρμας εισαγωγής
if ((newBookForm = document.querySelector("#new-book-form"))) {
  newBookForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-new-book");
    const required = document.querySelectorAll(".required");
    const edition = document.querySelector("#book-edition").value;
    const year = document.querySelector("#book-year").value;
    const eudoxusId = document.querySelector("#book-eudoxus-id").value;
    const books = document.querySelectorAll("table tbody tr");
    const maxLengthId = 15;
    const maxLengthEdition = 2;
    const maxLengthYear = 4;
    const maxLengthEudoxusId = 8;

    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[0].children[1].value.length > maxLengthId) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthId}.`
      );
      dataOk = false;
    }

    if (alreadyExists(books, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει εγγραφή με κωδικό ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (edition.length > maxLengthEdition) {
      showMessage(
        error,
        `Σφάλμα: Η έκδοση υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEdition}.`
      );
      dataOk = false;
    }

    if (edition.length > maxLengthEdition) {
      showMessage(
        error,
        `Σφάλμα: Η έκδοση υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEdition}.`
      );
      dataOk = false;
    }

    if (year.length > maxLengthYear) {
      showMessage(
        error,
        `Σφάλμα: Η χρονολογία υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthYear}.`
      );
      dataOk = false;
    }

    if (eudoxusId.length > maxLengthEudoxusId) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός στον Εύδοξο υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEudoxusId}.`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Validation φόρμα τροποποίησης
if ((updateBookForm = document.querySelector("#update-book-form"))) {
  updateBookForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-update-book");
    const required = document.querySelectorAll(".required");
    const edition = document.querySelector("#book-edition").value;
    const year = document.querySelector("#book-year").value;
    const eudoxusId = document.querySelector("#book-eudoxus-id").value;
    const maxLengthEdition = 2;
    const maxLengthYear = 4;
    const maxLengthEudoxusId = 8;

    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (edition.length > maxLengthEdition) {
      showMessage(
        error,
        `Σφάλμα: Η έκδοση υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEdition}.`
      );
      dataOk = false;
    }

    if (year.length > maxLengthYear) {
      showMessage(
        error,
        `Σφάλμα: Η χρονολογία υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthYear}.`
      );
      dataOk = false;
    }

    if (eudoxusId.length > maxLengthEudoxusId) {
      showMessage(
        error,
        `Σφάλμα: Ο κωδικός στον Εύδοξο υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEudoxusId}.`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// EΙΣΑΓΩΓΗ ΚΑΘΗΓΗΤΗ
// Validation φόρμας εισαγωγής
if ((newTeacherForm = document.querySelector("#new-teacher-form"))) {
  newTeacherForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-new-teacher");
    const required = document.querySelectorAll(".required");
    const teachers = document.querySelectorAll("table tbody tr");
    const maxLengthPhone = 10;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (alreadyExists(teachers, required[0].children[1].value, 0)) {
      showMessage(
        error,
        `Σφάλμα: Υπάρχει καθηγητής με κωδικό ${required[0].children[1].value}`
      );
      dataOk = false;
    }

    if (required[6].children[1].value.length > maxLengthPhone) {
      showMessage(
        error,
        `Σφάλμα: Το τηλέφωνο υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthPhone}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// validate φόρμα τροποποίησης
if ((editTeacherForm = document.querySelector("#edit-teacher-form"))) {
  editTeacherForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-edit-teacher");
    const required = document.querySelectorAll(".required");
    const maxLengthPhone = 10;
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[6].children[1].value.length > maxLengthPhone) {
      showMessage(
        error,
        `Σφάλμα: Το τηλέφωνο υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthPhone}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// ΠΡΟΣΘΗΚΗ ΝΕΟΥ ΜΑΘΗΜΑΤΟΣ
// Validate φόρμα εισαγωγής
if ((newLessonForm = document.querySelector("#new-lesson-form"))) {
  newLessonForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-new-lesson");
    const required = document.querySelectorAll(".required");
    const maxLengthId = 13;
    const maxLengthEcts = 4;

    let dataOk = true;

    if (isEmpty(required)) {
      window.location = "#section-one";
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[0].children[1].value.length > maxLengthId) {
      window.location = "#section-one";
      showMessage(
        error,
        `Σφάλμα: O κωδικός υπερβαίνει το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthId}`
      );
      dataOk = false;
    }

    if (required[4].children[1].value.length > maxLengthEcts) {
      window.location = "#section-one";
      showMessage(
        error,
        `Σφάλμα: Oι μονάδες ECTS υπερβαίνoυν το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEcts}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// ΠΡΟΣΘΗΚΗ/ΤΡΟΠΟΠΟΙΗΣΗ ΜΑΘΗΜΑΤΟΣ
// Validate φόρμα εισαγωγής
if ((newTeachingForm = document.querySelector("#teaching-form"))) {
  newTeachingForm.addEventListener("submit", function (e) {
    let dataOk = true;
    const error = document.querySelector(".error-teaching");
    const required = document.querySelectorAll(".required");
    const allLessons = document.querySelectorAll(".teaching-lesson-code");

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    for (let i = 0; i < allLessons.length; i++) {
      if (allLessons[i].textContent === required[0].children[1].value) {
        showMessage(error, `Σφάλμα: To μάθημα διδάσκεται ήδη από τον καθηγητή`);
        dataOk = false;
      }
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

if ((editLessonForm = document.querySelector("#edit-lesson-form"))) {
  editLessonForm.addEventListener("submit", function (e) {
    const error = document.querySelector(".error-edit-lesson");
    const required = document.querySelectorAll(".required-lesson-basic");
    console.log(required);

    const maxLengthEcts = 4;
    let dataOk = true;

    if (isEmpty(required)) {
      window.location = "#section-one";
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[1].children[1].value.length > maxLengthEcts) {
      window.location = "#section-one";
      showMessage(
        error,
        `Σφάλμα: Oι μονάδες ECTS υπερβαίνoυν το μέγιστο πλήθος ψηφίων. Μέγιστο πλήθος ψηφίων ${maxLengthEcts}`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });

  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

// Τροποποίση Οργάνωσης Διδασκαλίας
if (
  (editTeachOrganizeForm = document.querySelector(
    "#update-teach-organize-form"
  ))
) {
  editTeachOrganizeForm.addEventListener("submit", function (e) {
    const inputs = document.querySelectorAll(".organize");
    const error = document.querySelector(".error-update-teach-organize");
    let dataOk = true;
    const compare = /^[0-9]{1,2}$/g;
    for (let i = 0; i < inputs.length; i++) {
      if (inputs[i].children[1].value !== "") {
        if (!inputs[i].children[1].value.match(compare)) {
          showMessage(
            error,
            `Σφάλμα: Η τιμή ${inputs[i].children[1].value} δεν είναι αριθμός`
          );
          dataOk = false;
        }
      }
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });

  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  if ((organizeResetBtn = document.querySelector("#organize-reset-btn"))) {
    organizeResetBtn.addEventListener("click", function () {
      const inputs = document.querySelectorAll(".organize-teaching");
      for (let i = 0; i < inputs.length; i++) {
        inputs[i].style.borderColor = "#D1D3E2";
      }
    });
  }
}

// Εισαγωγή νέας εβδομάδας στο πρόγραμμα του μαθήματος
if ((newWeekScheduleForm = document.querySelector("#new-week-schedule"))) {
  newWeekScheduleForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required-insert");
    const error = document.querySelector(".error-new-schedule");
    const weeks = document.querySelectorAll("table tbody tr");
    let dataOk = true;
    let week;
    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (required[0].children[1].value.length == 1) {
      week = "0" + required[0].children[1].value;
    } else {
      week = required[0].children[1].value;
    }

    if (alreadyExists(weeks, week, 0)) {
      showMessage(
        error,
        `Σφάλμα: H το πρόγραμμα της εβδομάδας ${week} έχει ήδη οριστεί`
      );
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Τροποποίηση εβδομαδιαίου Προγράμματος
if ((editWeeklySchedule = document.querySelector("#update-weekly-schedule"))) {
  editWeeklySchedule.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required");
    const error = document.querySelector(".error-update-schedule");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
  // Αλλαγή border color όταν αλλάζουν οι τιμές του input
  changeBorderColor();
}

if ((editLessonSectionTwo = document.getElementById("edit-lesson-abilities"))) {
  const resetBtn = document.querySelector("#abilities-reset");
  resetBtn.addEventListener("click", () => {
    if (document.querySelectorAll('input[type="checkbox"]')) {
      const boxes = document.querySelectorAll(".abilities-checkbox");
      for (let i = 0; i < boxes.length; i++) {
        boxes[i].nextElementSibling.style.color = "#858796";
      }
    }
  });
}

if (
  (editLessonSectionTwo = document.getElementById("edit-lesson-assessment"))
) {
  const resetBtn = document.querySelector("#assessment-reset");
  resetBtn.addEventListener("click", () => {
    if (document.querySelectorAll('input[type="checkbox"]')) {
      const boxes = document.querySelectorAll(".assessment-checkbox");
      for (let i = 0; i < boxes.length; i++) {
        boxes[i].nextElementSibling.style.color = "#858796";
      }
    }
  });
}

if ((editLessonSectionTwo = document.getElementById("edit-lesson-tech"))) {
  const resetBtn = document.querySelector("#tech-reset");
  resetBtn.addEventListener("click", () => {
    if (document.querySelectorAll('input[type="checkbox"]')) {
      const boxes = document.querySelectorAll(".tech-checkbox");
      for (let i = 0; i < boxes.length; i++) {
        boxes[i].nextElementSibling.style.color = "#858796";
      }
    }
  });
}

// Εισαγωγή νέας τεχνολογίας από καθηγητή
if ((newTechForm = document.querySelector("#new-tech-form"))) {
  newTechForm.addEventListener("submit", function (e) {
    const required = document.querySelectorAll(".required-tech");
    const error = document.querySelector(".error-new-tech");
    let dataOk = true;

    if (isEmpty(required)) {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}

// Εισαγωγή νέας Ικανότητας από απλό καθηγητή
if ((newAblyForm = document.querySelector("#new-ablt-form"))) {
  newAblyForm.addEventListener("submit", function (e) {
    const title = document.getElementById("ability-title");
    const error = document.querySelector(".error-new-ability");
    let dataOk = true;
    console.log(title);
    if (title.value === "") {
      showMessage(error, `Σφάλμα: Υπάρχουν υποχρεωτικά πεδία που είναι κενά`);
      dataOk = false;
    }

    if (!dataOk) {
      e.preventDefault();
    } else {
      this.submit;
    }
  });
}
