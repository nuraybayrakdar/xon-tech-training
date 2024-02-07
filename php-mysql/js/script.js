function checkTodo(checkbox) {
    var todoId = checkbox.getAttribute('data-todo-id');
    var checked = checkbox.checked ? 1 : 0;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'check.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response !== '1') {
                    console.error('İşlem başarısız');
                }
            } else {
                console.error('İstek sırasında bir hata oluştu.');
            }
        }
    };
    xhr.send('id=' + todoId + '&checked=' + checked);
}

function deleteTodo(todoId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "remove.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response === '1') {
                    var todoElement = document.getElementById(todoId);
                    if (todoElement) {
                        todoElement.parentNode.removeChild(todoElement);
                    }
                } else {
                    console.error("Silme işlemi başarısız.");
                }
            } else {
                console.error("İstek sırasında bir hata oluştu.");
            }
        }
    };
    xhr.send("id=" + todoId);
}


