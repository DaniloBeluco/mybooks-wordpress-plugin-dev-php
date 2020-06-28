<?php
global $wpdb;
$all_books = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM " . my_book_table() . " ORDER BY id DESC", ""),
    ARRAY_A
);
?>

<div class="container">
    <br />
    <div class="col-md-12">
        <div class="row">

                <h2>Books List</h2>
            <div class="card">
                <div class="card-header">
                    Meus livros cadastrados
                </div>
                <div class="card-body">
                    <table id="my-book" class="display table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nome</th>
                                <th>Autor</th>
                                <th>Sobre</th>
                                <th>Imagem</th>
                                <th>Data de criação</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (count($all_books) > 0) :

                                $i = 1;
                                foreach ($all_books as $key => $value) : ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $value['name']; ?></td>
                                        <td><?php echo $value['author']; ?></td>
                                        <td><?php echo $value['about']; ?></td>
                                        <td> <img src="<?php echo $value['book_image']; ?>" style="width:40px;height:40px;"></td>
                                        <td><?php echo $value['created_at']; ?></td>
                                        <td>
                                            <a href="admin.php?page=edit&edit=<?php echo $value['id']; ?>" class="btn btn-info">Editar</a>
                                            <a href="javascript:void(0)" data-id="<?php echo $value['id']; ?>" class="btn btn-danger btnbookdelete">Deletar</a>

                                        </td>
                                    </tr>

                            <?php endforeach;

                            endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>