<?php
 if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
  $card = Painel::select('tb_galeria','id = ?',array($id));
 }else{
    Painel::alert('erro','Você precisa passar o parametro ID.');
  die();
 }
?>
<div class="box-content">
	<h2><i class="fa-solid fa-pencil"></i> Editar Card</h2>
	<form method="post" enctype="multipart/form-data">
		<?php
		   if(isset($_POST['acao'])){
             //Enviei o meu formulario
               
               $nome = $_POST['nome'];
               $imagem = $_FILES['imagem'];
               $imagem_atual = $_POST['imagem_atual'];

               if($imagem['name'] != ''){
               	//Existe o upload de imagem.
                if(Painel::imagemValida($imagem)){
                	Painel::deleteFile($imagem_atual);
                	$imagem = Painel::uploadFile($imagem);
                	$arr = ['nome'=>$nome,'card'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_galeria'];
                  Painel::update($arr);
                  $card = Painel::select('tb_galeria','id = ?',array($id));
                  Painel::alert('sucesso','O slide foi editado junto com a imagem');
                }else{
                	Painel::alert('erro','O formato da imagem não é valido');
                }
               }else{
               	  $imagem = $imagem_atual;
               	  $arr = ['nome'=>$nome,'card'=>$imagem,'id'=>$id,'nome_tabela'=>'tb_site.slides'];
                  Painel::update($arr);
                  $card = Painel::select('tb_galeria','id = ?',array($id));
                  Painel::alert('sucesso','A sua foto editada com sucesso!');
               }
		   }
		?>
		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome" required value="<?php echo $card['nome']; ?>" />
		</div><!--form-group-->
		<div class="form-group">
			<label>Imagem:</label>
			<input type="file" name="imagem" />
			<input type="hidden" name="imagem_atual" value="<?php echo $card['card']; ?>">
		</div><!--form-group-->
		<div class="form-group">
			<input type="submit" name="acao" value="Atualizar!" />
		</div><!--form-group-->
	</form>
</div><!--box-content-->