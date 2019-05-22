
<html>
<body>
<div class="createpost">
            <form method="post" action="" onsubmit="return validatePost()" enctype="multipart/form-data">
                <h2>Crear un Post</h2>
                <hr>
                <span style="float:right; color:black">
                <input type="checkbox" id="public" name="public">
                <label for="public">Publico</label>
                </span>
                Texto <span class="required" style="display:none;"> *No puedes dejar a tu publicación sin un texto</span><br>
                <textarea rows="6" name="caption"></textarea>
                <center><img src="" id="preview" style="max-width:580px; display:none;"></center>
                <div class="createpostbuttons">
                    <!--<form action="" method="post" enctype="multipart/form-data" id="imageform">-->
                    <label>
                        <img src="images/photo.png">
                        <input type="file" name="fileUpload" id="imagefile">
                        <!--<input type="submit" style="display:none;">-->
                    </label>
                    <input type="submit" value="Post" name="post">
                    <!--</form>-->
                </div>
            </form>
        </div>
	</body>
</html>