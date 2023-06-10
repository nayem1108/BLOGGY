<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tiny.cloud/1/rwlqhpvdqtwnwh15bd6f8zsryh3vxcz0lxr25jagm2whxtaz/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <form action="tiny.php" method="post">
        <input type="text" placeholder="Name">
        <textarea name="description">
        </textarea>
        <button type="submit">SUbmit</button>
    </form>
        
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
    });
  </script>
</body>
</html>