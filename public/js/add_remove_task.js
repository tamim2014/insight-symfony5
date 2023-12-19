function get_task() {
  var tasks = new Array;
  var tasks_str = localStorage.getItem('diversTodo'); /* diversTodo est la variable à modifier pour distinguer le script todo_divers.js et le script todo_prieres.js  */
  if (tasks_str !== null) {
    tasks = JSON.parse(tasks_str);
  }
  return tasks;
}

function addTask() {
  var taskdivers = document.getElementById('taskdivers').value;
  var tasks = get_task();
  if (taskdivers === '') {
    alert("Vous n'avez rien écrit!");
  } else {
    tasks.push(taskdivers);
    localStorage.setItem('diversTodo', JSON.stringify(tasks));
    show();
  }
  document.getElementById("taskdivers").value = ""; // Rafraichissement du champs de saisie( sinon la dernière valeur entrée reste là et oblige l'utilisateur à l'effacer à la main)

  return false;
}

function removeTask() {
  var id = this.getAttribute('id');
  var tasks = get_task();
  tasks.splice(id, 1);
  localStorage.setItem('diversTodo', JSON.stringify(tasks));

  show();

  return false;
}

function show() {
  var tasks = get_task();

  var html = '<ul>';
  for (var i = 0; i < tasks.length; i++) {
    html += '<li class="fait">' + tasks[i] + '<button class="remove" id="' + i + '">x</button></li>';
  };
  html += '</ul>';

  document.getElementById('tasks').innerHTML = html;

  var buttons = document.getElementsByClassName('remove');
  for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('click', removeTask);
  };
}

document.getElementById('add').addEventListener('click', addTask);

show();

// Add a "checked" symbol when clicking on a list item
/*
  ça prend pas mais c pas grav car 
    - ni le checked
    - ni la ligne
  rien est persisté. i fo trouver une solution.
  ces 2 effets i sont pas mal qd mm!

 */
/*
var list = document.querySelector('ul');
list.addEventListener('click', function (ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);
*/
// Add a "checked" symbol when clicking on a list item
var list = document.querySelector('ul');
list.addEventListener('click', function (ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);