<?php
/* Vamos usar a biblioteca de mídia para carregar a imagem */
wp_enqueue_media();

/* Pega os dados deste lovro no banco */
$book_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

global $wpdb;
$book_detail = $wpdb->get_row(
  $wpdb->prepare(
    "SELECT * FROM " . my_book_table() . " WHERE id = %d",
    $book_id
  ),
  ARRAY_A
);

?>
<div class="container"><br />
  <div class="row">
    <div class="alert alert-info">
      <h4>Book Add Page</h4>
    </div>
    <div class="card">
      <div class="card-header">
        Editar Livro
      </div>
      <div class="card-body">
        <span id="mb_success_message"></span>
        <form action="javascript:void(0)" id="frmEditBook">
          <input type="hidden" name="book_id" value="<?php echo isset($_GET['edit']) ? intval($_GET['edit']) : 0; ?>">
          <div class="form-group">
            <label for="name">Nome:</label>
            <input value="<?php echo $book_detail['name']; ?>" type="text" name="name" required class="form-control" id="name" placeholder="Entre com o nome do livro">
          </div>

          <div class="form-group">
            <label for="author">Autor:</label>
            <input value="<?php echo $book_detail['author']; ?>" type="text" name="author" required class="form-control" id="author" placeholder="Entre com o nome do autor">
          </div>

          <div class="form-group">
            <label for="about">Descrição:</label>
            <textarea name="about" required class="form-control" id="about" placeholder="Fale sobre o livro"><?php echo $book_detail['about']; ?></textarea>
          </div>

          <div class="form-group">
            <input type="button" class="btn btn-info" value="Upload Imagem" id="btn-upload" />
            <span id="show-image">
              <image src="<?php echo $book_detail['book_image']; ?>" style="max-width:70px;max-height:70px;" />
            </span>
            <input value="<?php echo $book_detail['book_image']; ?>" type="hidden" id="image_name" name="image_name">
          </div>

          <button type="submit" class="btn btn-success">Editar</button>
        </form>
      </div>
    </div>
  </div>
</div>