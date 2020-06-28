<?php
/* Vamos usar a biblioteca de mídia para carregar a imagem */
wp_enqueue_media();
?>

<div class="container"><br />
  <div class="row">
      <h2>Book Add Page</h2>
    <div class="card">
      <div class="card-header">
        Adicionar novo livro
      </div>
      <div class="card-body">
      <span id="mb_success_message"></span>
        <form action="javascript:void(0)" id="frmAddBook">
          <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" required class="form-control" id="name" placeholder="Entre com o nome do livro">
          </div>

          <div class="form-group">
            <label for="author">Autor:</label>
            <input type="text" name="author" required class="form-control" id="author" placeholder="Entre com o nome do autor">
          </div>

          <div class="form-group">
            <label for="about">Descrição:</label>
            <textarea name="about" required class="form-control" id="about" placeholder="Fale sobre o livro"></textarea>
          </div>

          <div class="form-group">
            <input type="button" class="btn btn-info" value="Upload Imagem" id="btn-upload" />
            <span id="show-image"></span>
            <input type="hidden" id="image_name" name="image_name">
          </div>

          <button type="submit" class="btn btn-success">Enviar</button>
        </form>
        
      </div>
    </div>
  </div>
</div>