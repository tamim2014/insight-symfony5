
function checkboxEdit() {
  const collection = document.getElementsByClassName('edit');
  // let remove = document.getElementById('remove');
  for (let i = 0; i < collection.length; i++) {
    if (collection[i].checked === true) {
      let n = collection[i].value;
      window.location.href = "https://localhost:8000/t/edit/" + n;
    }
  }
}

function checkboxRemove() {
  const collection = document.getElementsByClassName('remove');

  for (let i = 0; i < collection.length; i++) {
    if (collection[i].checked === true) {
      let n = collection[i].value;
      window.location.href = "https://localhost:8000/t/remove/" + n;
    }
  }
}
