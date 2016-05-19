<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        
        function getNextTree(S,htmlID){
            $(document).ready(function() {
                $.ajax({
                    url: "http://www.khanacademy.org/api/v1/topic/" + S +"?lang=es",
                    error: function(xhr){
                        getNextTree("math");
                    },
                    success: function(data){
                        var child = data.children;
                        $(htmlID).append("<h1>" + data.translated_title + "</h1>");
                        $(htmlID).append("<ul class='main'>");
                        $.each(child,function(){
                            if(this.kind == "Video" || this.kind == "Topic"){
                                if(this.kind == "Video"){
                                    $(htmlID).append("<li>" + this.translated_title + "</li>");
                                    $(htmlID).append("<ul><li id=" + this.id + " class='child'>" + this.translated_description + "</li></ul>");
                                    getVideo(this.id);
                                }else{
                                    $(htmlID).append("<li><a href='khanacademyJS.php?searchParam=" + this.id +"'>" + this.translated_title + "<\a></li>");
                                    $(htmlID).append("<ul><li id=" + this.id + " class='child'>" + this.translated_description + "</li></ul>");
                                }
                            }
                        });
                        var i = document.getElementsByClassName("child");
                        if(i.length == 0){
                            $(htmlID).append("No Hay contenido Disponible");
                        }
                        $(htmlID).append("</ul>");
                    }
                });
            });
        }
        
        function getVideo(ID){
            $.ajax({
                url: "http://www.khanacademy.org/api/v1/videos/" + ID + "?lang=es"
            }).then(function(data) {
                $("#" + ID).append('</br><iframe width="560" height="315" src="https://www.youtube.com/embed/' + data.youtube_id + '" frameborder="0" allowfullscreen></iframe>');
            });
        }
        
    </script>
</head>
<body>
    <a href="khanacademyJS.php?searchParam=math">Principal</a>
<div id="ytLink"></div>
<script>
    <?php if(isset($_GET['searchParam'])){?>
            getNextTree("<?php echo $_GET['searchParam']?>","#ytLink");
    <?php }else{ ?>
            getNextTree("root","#ytLink");
    <?php } ?>
</script>
</body>
</html>




