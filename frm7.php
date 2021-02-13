<div class="form-group">
	<label>Como você soube da vaga disponível?</label>
    <input type="text" name="comosoube" id="comosoube" class="form-control"  maxlength="100"/>
</div>

<div class="form-group">
	<label>Comentários gerais</label>
    <textarea name="comentarios" id="comentarios" class="form-control"></textarea>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-6">
            <h3>Comprovantes</h3>
            <div id="comp1">Enviar comprovante</div>
        </div>

        <div class="col-md-6">
            Comprovantes requeridos:<br>
            - Formação acadêmica<br>
			- Currículo Lates<br>
            - Declaração de experiência(s)<br>
            - Cópia do Título de Eleitor e Último Comprovante de Votação<br>
            - Cópia do Comprovante de Endereço com CEP<br>
            - Declaração (com as experiências exigidas da função) ou cópia da carteira da carteira profissional e das experiências
		</div>
	</div>
</div>


<div class="form-group">
	<input type="submit" class="btn btn-lg btn-success" value="Cadastrar Currículo"  />
</div>
</form>

<script>
$(function()
{
$("#comp1").uploadFile({
  url: "ctrl/ctrlSite.php?acao=uploadComprovante",
  maxFileCount: 1,
  dragDrop: true,
  showFileCounter: false,
  fileName: "myfile",
  returnType: "json",
  formData: {"campo":"comprovante"},
  showDelete: true,
  showDownload:true,
  statusBarWidth:400,
  dragdropWidth:400,
  allowedTypes: "pdf",
  dragDropStr: "<span><b>Arraste e solte os arquivos</b></span>",
  abortStr:"Interromper",
  cancelStr:"Cancelar",
  doneStr:"Feito",
  multiDragErrorStr: "Vários arquivos arrastados não são permitidos.",
  extErrorStr:"não é permitido. Extensões permitidas:",
  sizeErrorStr:"não é permitido. Tamanho máximo permitido:",
  uploadErrorStr:"Upload não é permitido",
  uploadStr:"Enviar arquivo(s)",
  maxFileCountErrorStr: "Quantidade máxima de arquivos enviados atingida. Delete os arquivos existentes. Só é permitido o envio de um arquivo em formato PDF",
  
  onLoad:function(obj)
   {
    $.ajax({
        cache: false,
        url: "ctrl/ctrlSite.php?acao=buscaComprovante&campo=comprovante",
        dataType: "json",
        success: function(data) 
        {
          for(var i=0;i<data.length;i++)
          { 
            obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
          }
          }
    });
  },
  
  deleteCallback: function (data, pd) {
    for (var i = 0; i < data.length; i++) {
        $.post("ctrl/ctrlSite.php?acao=deletaComprovante", {folder: "comprovante", op: "delete",name: data[i]},
            function (resp,textStatus, jqXHR) {
                //Show Message  
                alert("Arquivo excluído");
            });
    }
    pd.statusbar.hide(); //You choice.
  },
  
  downloadCallback:function(filename,pd)
  {
    location.href="ctrl/ctrlSite.php?acao=downloadComprovante&campo=comprovante&filename="+filename;
  }
});
});
</script>