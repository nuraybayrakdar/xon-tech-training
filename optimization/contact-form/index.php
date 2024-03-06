<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.3/purify.min.js" integrity="sha384-..."></script>
</head>
<body>
    <h1>Contact Us</h1>
    <form id="contactForm">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>

        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50"></textarea><br>

        <button type="submit">Send</button>
    </form>

    <div id="comments"></div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var comment = document.getElementById('comment').value;

            // DOMPrufiy kullanarak XSS saldırılarını önlemiş olduk
            var cleanName = DOMPurify.sanitize(name);
            var cleanEmail = DOMPurify.sanitize(email);
            var cleanComment = DOMPurify.sanitize(comment);

           
            var commentElement = document.createElement('div');
            commentElement.innerHTML = '<strong>Name:</strong> ' + cleanName + '<br>' +
                                        '<strong>Email:</strong> ' + cleanEmail + '<br>' +
                                        '<strong>Comment:</strong> ' + cleanComment + '<br><br>';
            document.getElementById('comments').appendChild(commentElement);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'post_comment.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };
            var data = 'name=' + encodeURIComponent(cleanName) + '&email=' + encodeURIComponent(cleanEmail) + '&comment=' + encodeURIComponent(cleanComment);
            xhr.send(data);

            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('comment').value = '';
        });
    </script>
</body>
</html>
