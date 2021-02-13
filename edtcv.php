<?
$acaolocal = "editacv";
include('ctrl/ctrlSite.php');

verificaLogado();

include('inc_header.php');?>

<div class="container-fluid barraUsuario cb">

	<div class="container">
		<span class="fl">Olá, <?=$_SESSION['rgr']['emailUsuario'];?></span>
        <span class="fr"><a href="<?=$_SERVER['PHP_SELF']?>?acao=deslogar">Deslogar</a></span>
    </div>
</div>


<header class="container text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo.png">
    </div>
</header>

<? include('inc_menu.php');?>

<div class="container">
	<div class="row">
		<h1 class="text-center">Atualizar informações do currículo</h1>
	</div>

    <div class="row">
		<div class="avisoCV vc fw6 <?=$classecv;?>"><?=$avisoCV;?></div>

		<?php
			if($classecv == 'ok'){?>
				<div class="alert alert-info">
					Para concorrer a uma vaga, siga as seguintes etapas:<br>
					- Acesse as vagas através do menu "Vagas" ou <a href="https://www.institutoreger.org.br/processoseletivo/usuario.php"><b>clique aqui</b></a><br>
					- Escolha o edital que deseja e clique no botão "Clique para ver mais detalhes"<br>
					- As vagas do edital serão listadas, escolha sua vaga e clique em "mais informações"<br>
					- Na próxima página, você verá todos os detalhes da vaga e no final da página, o botão para se candidatar<br>
					- Após se inscrever, o botão ficará verde claro e aparecerá o texto "Inscrição realizada". Isto significa que sua inscrição foi realizada com sucesso e você receberá a confirmação por e-mail.
				</div>
		<?php	}
		?>
    </div>
	<? if($statusatt != 'ok'){?>
    <div class="row">
        <div id="rootwizard">
            <div class="navbar">
              <div class="navbar-inner">
                    <ul class="navetapas">
                        <li><a href="#tab1" data-toggle="tab">Informações pessoais</a></li>
                        <li><a href="#tab2" data-toggle="tab">Documentos complementares</a></li>
                        <li><a href="#tab3" data-toggle="tab">Formação acadêmica</a></li>
                        <li><a href="#tab4" data-toggle="tab">Informações adicionais</a></li>
                        <li><a href="#tab5" data-toggle="tab">Experiência profissional</a></li>
                        <li><a href="#tab6" data-toggle="tab">Capacitações profissionais/Cursos</a></li>
                        <li><a href="#tab7" data-toggle="tab">Outras informações</a></li>
                    </ul>
              </div>
            </div>

            <div class="tab-content  col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="tab-pane" id="tab1">
                <form name="frmCv" id="frmCv" method="post" encyte="multipart/form-data"  action="<?=$_SERVER['PHP_SELF'];?>?acao=atualizacv" onsubmit="return validafrmCv(this);">
                    <div class="form-group">
                      <label>Nome</label>
                      <input type="text" name="nome" id="nome" class="form-control" value="<?=$cv2['nome'];?>" maxlength="200" />
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-8">
                          <label>E-mail</label>
                          <input type="email" name="email" id="email" class="form-control" value="<?=$cv['email'];?>" maxlength="100" />
                        </div>
                        <div class="col-md-4">
                          <label>Gênero</label>
                          <select name="genero" id="genero" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Masculino" <? if($cv2['genero'] == "Masculino"){ echo "selected";}?>>Masculino</option>
                            <option value="Feminino"  <? if($cv2['genero'] == "Feminino"){ echo "selected";}?>>Feminino</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-8">
                          <label>Estado Civil</label>
                          <select name="estadocivil" id="estadocivil" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Solteiro(a)" <? if($cv2['estadocivil'] == "Solteiro(a)"){ echo "selected";}?>>Solteiro(a)</option>
                            <option value="Casado(a)" <? if($cv2['estadocivil'] == "Casado(a)"){ echo "selected";}?>>Casado(a)</option>
                            <option value="Divorciado(a)" <? if($cv2['estadocivil'] == "Divorciado(a)"){ echo "selected";}?>>Divorciado(a)</option>
                            <option value="Viúvo(a)" <? if($cv2['estadocivil'] == "Viúvo(a)"){ echo "selected";}?>>Viúvo(a)</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label>Data de nascimento</label>
                          <input type="text" name="nascimento" id="nascimento" class="datepicker form-control" value="<?=formataData($cv2['nascimento'], 'php');?>"  maxlength="10"  />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Pessoa (PcD)</label>
                          <select name="pcd" id="pcd" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Sim" <? if($cv2['pcd'] == "Sim"){ echo "selected";}?>>Sim</option>
                            <option value="Não" <? if($cv2['pcd'] == "Não"){ echo "selected";}?>>Não</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label>Tipo de deficiência</label>
                          <input type="text" name="deficiencia" id="deficiencia" class="form-control" value="<?=$cv2['tipopcd'];?>"  maxlength="150"  />
                        </div>
                        <div class="col-md-4">
                          <label>CID</label>
                          <input type="text" name="cid" id="cid" class="form-control" value="<?=$cv2['cid'];?>"  maxlength="40" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Tem filhos?</label>
                          <select name="filhos" id="filhos" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Sim" <? if($cv2['filhos'] == "Sim"){ echo "selected";}?>>Sim</option>
                            <option value="Não" <? if($cv2['filhos'] == "Não"){ echo "selected";}?>>Não</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label>Quantos</label>
                          <input type="number" name="qtyfilhos" id="qtyfilhos" class="form-control" value="<?=$cv2['qtyfilhos'];?>"  maxlength="2" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-2">
                          <label>CEP</label>
                          <input type="text" name="cep" id="cep" class="form-control" onblur="pesquisacep(this.value);" value="<?=$cv2['cep'];?>"  maxlength="10" />
                        </div>
                        <div class="col-md-8">
                          <label>Rua</label>
                          <input type="text" name="rua" id="rua" class="form-control" value="<?=$cv2['endereco'];?>"  maxlength="250" />
                        </div>
                        <div class="col-md-2">
                          <label>Número</label>
                          <input type="number" name="numero" id="numero" class="form-control" value="<?=$cv2['numero'];?>"  maxlength="6" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Complemento (Quadra, Lote, Torre, etc)</label>
                      <input type="text" name="complemento" id="complemento" class="form-control" value="<?=$cv2['complemento'];?>"  maxlength="250" />
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Bairro</label>
                          <input type="text" name="bairro" id="bairro" class="form-control" value="<?=$cv2['bairro'];?>" maxlength="50"  />
                        </div>
                        <div class="col-md-4">
                          <label>Cidade</label>
                          <input type="text" name="cidade" id="cidade" class="form-control" value="<?=$cv2['cidade'];?>"  maxlength="50" />
                        </div>
                        <div class="col-md-4">
                          <label>UF</label>
                          <select class="form-control" name="uf" id="uf">
                            <option value="">Selecione</option>
                            <option value="AC" <? if($cv2['uf'] == "AC"){ echo "selected";}?>>Acre</option>
                            <option value="AL" <? if($cv2['uf'] == "AL"){ echo "selected";}?>>Alagoas</option>
                            <option value="AP" <? if($cv2['uf'] == "AP"){ echo "selected";}?>>Amapá</option>
                            <option value="AM" <? if($cv2['uf'] == "AM"){ echo "selected";}?>>Amazonas</option>
                            <option value="BA" <? if($cv2['uf'] == "BA"){ echo "selected";}?>>Bahia</option>
                            <option value="CE" <? if($cv2['uf'] == "CE"){ echo "selected";}?>>Ceará</option>
                            <option value="DF" <? if($cv2['uf'] == "DF"){ echo "selected";}?>>Distrito Federal</option>
                            <option value="ES" <? if($cv2['uf'] == "ES"){ echo "selected";}?>>Espírito Santo</option>
                            <option value="GO" <? if($cv2['uf'] == "GO"){ echo "selected";}?>>Goiás</option>
                            <option value="MA" <? if($cv2['uf'] == "MA"){ echo "selected";}?>>Maranhão</option>
                            <option value="MT" <? if($cv2['uf'] == "MT"){ echo "selected";}?>>Mato Grosso</option>
                            <option value="MS" <? if($cv2['uf'] == "MS"){ echo "selected";}?>>Mato Grosso do Sul</option>
                            <option value="MG" <? if($cv2['uf'] == "MG"){ echo "selected";}?>>Minas Gerais</option>
                            <option value="PA" <? if($cv2['uf'] == "PA"){ echo "selected";}?>>Pará</option>
                            <option value="PB" <? if($cv2['uf'] == "PB"){ echo "selected";}?>>Paraíba</option>
                            <option value="PR" <? if($cv2['uf'] == "PA"){ echo "selected";}?>>Paraná</option>
                            <option value="PE" <? if($cv2['uf'] == "PE"){ echo "selected";}?>>Pernambuco</option>
                            <option value="PI" <? if($cv2['uf'] == "PI"){ echo "selected";}?>>Piauí</option>
                            <option value="RJ" <? if($cv2['uf'] == "RJ"){ echo "selected";}?>>Rio de Janeiro</option>
                            <option value="RN" <? if($cv2['uf'] == "RN"){ echo "selected";}?>>Rio Grande do Norte</option>
                            <option value="RS" <? if($cv2['uf'] == "RS"){ echo "selected";}?>>Rio Grande do Sul</option>
                            <option value="RO" <? if($cv2['uf'] == "RO"){ echo "selected";}?>>Rondônia</option>
                            <option value="RR" <? if($cv2['uf'] == "RR"){ echo "selected";}?>>Roraima</option>
                            <option value="SC" <? if($cv2['uf'] == "SC"){ echo "selected";}?>>Santa Catarina</option>
                            <option value="SP" <? if($cv2['uf'] == "SP"){ echo "selected";}?>>São Paulo</option>
                            <option value="SE" <? if($cv2['uf'] == "SE"){ echo "selected";}?>>Sergipe</option>
                            <option value="TO" <? if($cv2['uf'] == "TO"){ echo "selected";}?>>Tocantins</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Telefone residencial</label>
                          <input type="text" name="tel_res" id="tel_res" class="form-control" value="<?=$cv2['tel_res'];?>"  maxlength="15" />
                        </div>
                        <div class="col-md-4">
                          <label>Telefone celular</label>
                          <input type="text" name="tel_cel" id="tel_cel" class="form-control" value="<?=$cv2['tel_cel'];?>"  maxlength="15" />
                        </div>
                        <div class="col-md-4">
                          <label>Telefone comercial</label>
                          <input type="tel" name="tel_com" id="tel_com" class="form-control" value="<?=$cv2['tel_com'];?>" maxlength="15"  />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Recados aos cuidados de:</label>
                      <input type="text" name="recados" id="recados" class="form-control" value="<?=$cv2['aoscuidados'];?>"  maxlength="40" />
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Naturalidade</label>
                          <input type="text" name="naturalidade" id="naturalidade" class="form-control" value="<?=$cv2['naturalidade'];?>" maxlength="30"  />
                        </div>
                        <div class="col-md-6">
                          <label>Nacionalidade</label>
                          <input type="text" name="nacionalidade" id="nacionalidade" class="form-control" value="<?=$cv2['nacionalidade'];?>"  maxlength="30" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Nome da mãe</label>
                          <input type="text" name="mae" id="mae" class="form-control" value="<?=$cv2['mae'];?>" maxlength="150"  />
                        </div>
                        <div class="col-md-6">
                          <label>Nome do pai</label>
                          <input type="text" name="pai" id="pai" class="form-control" value="<?=$cv2['pai'];?>"  maxlength="150" />
                        </div>
                      </div>
                    </div>

                </div>

                <div class="tab-pane" id="tab2">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>RG</label>
                            <input type="number" name="rg" id="rg" class="form-control" value="<?=$cv3['rg'];?>"  maxlength="20"/>
                        </div>
                        <div class="col-md-4">
                            <label>Órgão emissor</label>
                            <input type="text" name="emissor" id="emissor" class="form-control" value="<?=$cv3['emissor'];?>" maxlength="10" />
                        </div>
                        <div class="col-md-4">
                            <label>UF</label>
                               <select class="form-control" name="ufrg" id="ufrg">
                                  <option value="">Selecione</option>
                                  
                            <option value="AC" <? if($cv3['uf'] == "AC"){ echo "selected";}?>>Acre</option>
                            <option value="AL" <? if($cv3['uf'] == "AL"){ echo "selected";}?>>Alagoas</option>
                            <option value="AP" <? if($cv3['uf'] == "AP"){ echo "selected";}?>>Amapá</option>
                            <option value="AM" <? if($cv3['uf'] == "AM"){ echo "selected";}?>>Amazonas</option>
                            <option value="BA" <? if($cv3['uf'] == "BA"){ echo "selected";}?>>Bahia</option>
                            <option value="CE" <? if($cv3['uf'] == "CE"){ echo "selected";}?>>Ceará</option>
                            <option value="DF" <? if($cv3['uf'] == "DF"){ echo "selected";}?>>Distrito Federal</option>
                            <option value="ES" <? if($cv3['uf'] == "ES"){ echo "selected";}?>>Espírito Santo</option>
                            <option value="GO" <? if($cv3['uf'] == "GO"){ echo "selected";}?>>Goiás</option>
                            <option value="MA" <? if($cv3['uf'] == "MA"){ echo "selected";}?>>Maranhão</option>
                            <option value="MT" <? if($cv3['uf'] == "MT"){ echo "selected";}?>>Mato Grosso</option>
                            <option value="MS" <? if($cv3['uf'] == "MS"){ echo "selected";}?>>Mato Grosso do Sul</option>
                            <option value="MG" <? if($cv3['uf'] == "MG"){ echo "selected";}?>>Minas Gerais</option>
                            <option value="PA" <? if($cv3['uf'] == "PA"){ echo "selected";}?>>Pará</option>
                            <option value="PB" <? if($cv3['uf'] == "PB"){ echo "selected";}?>>Paraíba</option>
                            <option value="PR" <? if($cv3['uf'] == "PA"){ echo "selected";}?>>Paraná</option>
                            <option value="PE" <? if($cv3['uf'] == "PE"){ echo "selected";}?>>Pernambuco</option>
                            <option value="PI" <? if($cv3['uf'] == "PI"){ echo "selected";}?>>Piauí</option>
                            <option value="RJ" <? if($cv3['uf'] == "RJ"){ echo "selected";}?>>Rio de Janeiro</option>
                            <option value="RN" <? if($cv3['uf'] == "RN"){ echo "selected";}?>>Rio Grande do Norte</option>
                            <option value="RS" <? if($cv3['uf'] == "RS"){ echo "selected";}?>>Rio Grande do Sul</option>
                            <option value="RO" <? if($cv3['uf'] == "RO"){ echo "selected";}?>>Rondônia</option>
                            <option value="RR" <? if($cv3['uf'] == "RR"){ echo "selected";}?>>Roraima</option>
                            <option value="SC" <? if($cv3['uf'] == "SC"){ echo "selected";}?>>Santa Catarina</option>
                            <option value="SP" <? if($cv3['uf'] == "SP"){ echo "selected";}?>>São Paulo</option>
                            <option value="SE" <? if($cv3['uf'] == "SE"){ echo "selected";}?>>Sergipe</option>
                            <option value="TO" <? if($cv3['uf'] == "TO"){ echo "selected";}?>>Tocantins</option>
                          </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <label>CPF</label>
                            <input type="number" name="cpf" id="cpf" class="form-control" value="<?=$cv3['cpf'];?>"  onblur="validarCPF(this);" />
                        </div>
                        <div class="col-md-5">
                            <label>CNH</label>
                            <input type="text" name="cnh" id="cnh" class="form-control" value="<?=$cv3['cnh'];?>"  maxlength="15"/>
                        </div>
                        <div class="col-md-2">
                            <label>Categoria</label>
                            <input type="text" name="categoria" id="categoria" class="form-control" value="<?=$cv3['categoria'];?>" maxlength="5" />
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>CTPS</label>
                            <input type="text" name="ctps" id="ctps" class="form-control" value="<?=$cv3['ctps'];?>" maxlength="15"/>
                        </div>
                        <div class="col-md-4">
                            <label>Série</label>
                            <input type="text" name="serie" id="serie" class="form-control" value="<?=$cv3['serie'];?>" maxlength="20" />
                        </div>
                        <div class="col-md-4">
                            <label>PIS/PASEP</label>
                            <input type="text" name="pispasep" id="pispasep" class="form-control" value="<?=$cv3['pispasep'];?>" maxlength="15"/>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Certificado de reservista</label>
                            <input type="text" name="reservista" id="reservista" class="form-control" value="<?=$cv3['reservista'];?>" maxlength="10"/>
                        </div>
                        <div class="col-md-6">
                            <label>Possui conta corrente na Caixa Econômica Federal?</label>
                            <select name="conta" id="conta" class="form-control">
                                <option value="">Selecione</option>
                                <option value="Sim" <? if($cv3['contacaixa'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                <option value="Não" <? if($cv3['contacaixa'] == 'Não'){ echo 'selected';}?>>Não</option>
                            </select>
                        </div>
                    </div>
                </div>
                </div>

                <div class="tab-pane" id="tab3">
                	<? $i=1; $numf = $det4->rowCount();?>
                    <? while($cv4 = $det4->fetch(PDO::FETCH_ASSOC)){?>
                    <h1>Curso:</h1>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Instituição</label>
                                <input type="text" name="instituicao<?=$i;?>" id="instituicao<?=$i;?>" class="form-control" value="<?=$cv4['instituicao'];?>"  maxlength="80"/>
                            </div>
                            <div class="col-md-6">
                                <label>Curso</label>
                                <input type="text" name="curso<?=$i;?>" id="curso" class="form-control" value="<?=$cv4['nome_curso'];?>"  maxlength="100"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status<?=$i;?>" id="status<?=$i;?>" class="form-control">
                                  <option value="">Selecione</option>
                                  <option value="Concluído" <? if($cv4['status'] == 'Concluído') { echo 'selected';}?>>Concluído</option>
                                  <option value="Em andamento" <? if($cv4['status'] == 'Em andamento') { echo 'selected';}?>>Em andamento</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Ano de conclusão. Exemplo: 02/2019</label>
                                <input type="text" name="conclusao<?=$i;?>" id="conclusao<?=$i;?>" class="form-control" value="<?=$cv4['conclusao'];?>"  maxlength="7"/>
                            </div>

                            <div class="col-md-4">
                              <label>Tipo do curso</label>
                              <select name="tipoGrad<?=$i;?>" class="form-control">
                                <option value="Licenciatura" <? if($cv4['tipograduacao'] == 'Licenciatura'){ echo 'selected';}?>>Licenciatura</option>
                                <option value="Bacharelado" <? if($cv4['tipograduacao'] == 'Bacharelado'){ echo 'selected';}?>>Bacharelado</option>
                                <option value="Tecnólogo" <? if($cv4['tipograduacao'] == 'Tecnólogo'){ echo 'selected';}?>>Tecnólogo</option>
                                <option value="Técnico" <? if($cv4['tipograduacao'] == 'Técnico'){ echo 'selected';}?>>Técnico</option>
                                <option value="Ensino Médio" <? if($cv4['tipograduacao'] == 'Ensino Médio'){ echo 'selected';}?>>Ensino Médio</option>
                                <option value="Ensino Fundamental" <? if($cv4['tipograduacao'] == 'Ensino Fundamental'){ echo 'selected';}?>>Ensino Fundamental</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <? $i++;}
					$extrafor = 2 - $numf;
					for($f = 1; $f<=$extrafor; $f++){ ?>
                    <? if($extrafor == 1) { $f++;}?>
                    <h1>Curso:</h1>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Instituição</label>
                                <input type="text" name="instituicao<?=$f;?>" id="instituicao<?=$f;?>" class="form-control"  maxlength="80"/>
                            </div>
                            <div class="col-md-6">
                                <label>Curso</label>
                                <input type="text" name="curso<?=$f;?>" id="curso" class="form-control"  maxlength="100"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Status</label>
                                  <select name="status<?=$f;?>" id="status<?=$f;?>" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Concluído">Concluído</option>
                                    <option value="Em andamento">Em andamento</option>
                                  </select>
                            </div>

                            <div class="col-md-4">
                                <label>Ano de conclusão. Exemplo: 02/2019</label>
                                <input type="text" name="conclusao<?=$f;?>" id="conclusao<?=$f;?>" class="form-control" maxlength="7" />
                            </div>
                            
                            <div class="col-md-4">
                              <label>Tipo do curso</label>
                              <select name="tipoGrad<?=$f;?>"  class="form-control">
                                <option value="Licenciatura">Licenciatura</option>
                                <option value="Bacharelado">Bacharelado</option>
                                <option value="Tecnólogo">Tecnólogo</option>
                                <option value="Técnico">Técnico</option>
                                <option value="Ensino Médio">Ensino Médio</option>
                                <option value="Ensino Fundamental">Ensino Fundamental</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <? } ?>
                </div>

                <div class="tab-pane" id="tab4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Disponbilidade para trabalhar aos finais de semana e feriados?</label>
                                <select name="fds" id="fds" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Sim" <? if($cv5['disp_trabalho'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                    <option value="Não" <? if($cv5['disp_trabalho'] == 'Não'){ echo 'selected';}?>>Não</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Disponiblidade para viagens?</label>
                                <select name="viagens" id="viagens" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Sim" <? if($cv5['disp_viagem'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                    <option value="Não" <? if($cv5['disp_viagem'] == 'Não'){ echo 'selected';}?>>Não</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Possui veículo próprio?</label>
                                <select name="veiculo" id="veiculo" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Sim" <? if($cv5['veiculo'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                    <option value="Não" <? if($cv5['veiculo'] == 'Não'){ echo 'selected';}?>>Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Trabalha no Estado?</label>
                                <select name="trabalha_estado" id="trabalha_estado" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Sim" <? if($cv5['trabalha_estado'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                    <option value="Não" <? if($cv5['trabalha_estado'] == 'Não'){ echo 'selected';}?>>Não</option>
                                </select>
                            </div>
                            
                            <div class="col-md-8">
                                <label>Se "SIM", em qual órgão?</label>
                                <input type="text" name="orgaotrabalha" id="orgaotrabalha" class="form-control" value="<?=$cv5['trabalha_estado_orgao'];?>" maxlength="60" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Trabalhou no Estado?</label>
                                <select name="trabalhou_estado" id="trabalhou_estado" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Sim" <? if($cv5['trabalhou_estado'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                    <option value="Não" <? if($cv5['trabalhou_estado'] == 'Não'){ echo 'selected';}?>>Não</option>
                                </select>
                            </div>
                            
                            <div class="col-md-8">
                                <label>Se "SIM", em qual órgão?</label>
                                <input type="text" name="orgaotrabalhou" id="orgaotrabalhou" class="form-control" value="<?=$cv5['trabalhou_estado_orgao'];?>"  maxlength="60"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Local</label>
                                <input type="text" name="local" id="local" class="form-control" value="<?=$cv5['trabalhou_estado_local'];?>"  maxlength="60"/>
                            </div>
                            <div class="col-md-3">
                                <label>Tipo de contratação</label>
                                <input type="text" name="tipocontratacao" id="tipocontratacao" class="form-control" value="<?=$cv5['trabalhou_estado_contratacao'];?>"  maxlength="30"/>
                            </div>
                            <div class="col-md-3">
                                <label>Há quanto tempo?</label>
                                <input type="text" name="qtotempo" id="qtotempo" class="form-control" value="<?=$cv5['trabalhou_estado_tempo'];?>" maxlength="30" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                            <label>Possui parentes ou afins no Instituto Reger?</label>
                                <select name="parentes" id="parentes" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="Sim" <? if($cv5['parente'] == 'Sim'){ echo 'selected';}?>>Sim</option>
                                    <option value="Não" <? if($cv5['parente'] == 'Não'){ echo 'selected';}?>>Não</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Se "SIM", qual área de atuação?</label>
                                <input type="text" name="atuacao" id="atuacao" class="form-control" value="<?=$cv5['parente_area'];?>"  maxlength="30"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Nome do parente</label>
                                <input type="text" name="nomeparente" id="nomeparente" class="form-control" value="<?=$cv5['parente_nome'];?>"  maxlength="50"/>
                            </div>
                            <div class="col-md-4">
                                <label>Grau de parentesco</label>
                                <input type="text" name="grau" id="grau" class="form-control" value="<?=$cv5['parente_grau'];?>"  maxlength="50"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab5">
                	<? $i = 1; $numexp = $det6->rowCount();?>
                    
                	<? while($cv6 = $det6->fetch(PDO::FETCH_ASSOC)){?>
                    <h1><? if($i==1){?>Experiência atual ou última<? } else {?>Penúltima experiência<? }?></h1>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nome da empresa</label>
                                <input type="text" name="nomeempresa<?=$i;?>" id="nomeempresa" class="form-control" value="<?=$cv6['nome_empresa'];?>"  maxlength="200" />
                            </div>
                            <div class="col-md-3">
                                <label>Cidade</label>
                                <input type="text" name="cidadeempresa<?=$i;?>" id="cidadeempresa" class="form-control" value="<?=$cv6['cidade'];?>"  maxlength="30"/>
                            </div>
                            <div class="col-md-3">
                                <label>Telefone</label>
                                <input type="tel" name="telempresa<?=$i;?>" id="telempresa" class="form-control" value="<?=$cv6['telefone'];?>"  maxlength="15"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Cargo</label>
                                <input type="text" name="cargoempresa<?=$i;?>" id="cargoempresa" class="form-control" value="<?=$cv6['cargo'];?>"  maxlength="200"/>
                            </div>
                            <div class="col-md-4">
                                <label>Data de início. Exemplo: 02/02/2012</label>
                                <input type="text" name="datainicio<?=$i;?>" id="datainicio<?=$i;?>" class="datepicker form-control" value="<?=formataData($cv6['inicio'], 'php');?>" />
                            </div>
                            <div class="col-md-4">
                                <label>Data de saída. Exemplo: 02/04/2014</label>
                                <input type="text" name="datasaida<?=$i;?>" id="datasaida<?=$i;?>" class="datepicker form-control" value="<?=formataData($cv6['termino'], 'php');?>" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Atividades exercidas</label>
                        <textarea name="atividades<?=$i;?>" id="atividades" class="form-control"><?=$cv6['atividades'];?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Última remuneração</label>
                                <input type="text" name="ultimaremuneracao<?=$i;?>" id="ultimaremuneracao" class="form-control" value="<?=$cv6['remuneracao'];?>"  maxlength="15"/>
                            </div>
                            <div class="col-md-8">
                                <label>Motivo da saída</label>
                                <input type="text" name="motivosaida<?=$i;?>" id="motivosaida" class="form-control" value="<?=$cv6['motivo_saida'];?>"  maxlength="150" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Nome para referência</label>
                                <input type="text" name="referencia<?=$i;?>" id="referencia" class="form-control" value="<?=$cv6['ref_nome'];?>"  maxlength="150"/>
                            </div>
                            <div class="col-md-4">
                                <label>Telefone</label>
                                <input type="tel" name="telref<?=$i;?>" id="telref" class="form-control" value="<?=$cv6['ref_tel'];?>"  maxlength="15"/>
                            </div>
                        </div>
                    </div>
                    <? $i++;}
					$extraexp = 2 - $numexp;
					for($b = 1; $b<=$extraexp; $b++){ ?>
                    <? if($extraexp == 1) {$b++;}?>
                    <h1><? if($b==1){?>Experiência atual ou última<? } else {?>Penúltima experiência<? }?></h1>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nome da empresa</label>
                                <input type="text" name="nomeempresa<?=$b;?>" id="nomeempresa" class="form-control"  maxlength="200"/>
                            </div>
                            <div class="col-md-3">
                                <label>Cidade</label>
                                <input type="text" name="cidadeempresa<?=$b;?>" id="cidadeempresa" class="form-control"  maxlength="30" />
                            </div>
                            <div class="col-md-3">
                                <label>Telefone</label>
                                <input type="tel" name="telempresa<?=$b;?>" id="telempresa" class="form-control"   maxlength="15"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Cargo</label>
                                <input type="text" name="cargoempresa<?=$b;?>" id="cargoempresa" class="form-control"  maxlength="200" />
                            </div>
                            <div class="col-md-4">
                                <label>Data de início</label>
                                <input type="text" name="datainicio<?=$b;?>" id="datainicio<?=$b;?>" class="datepicker form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Data de saída</label>
                                <input type="text" name="datasaida<?=$b;?>" id="datasaida<?=$b;?>" class="datepicker form-control"  />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Atividades exercidas</label>
                        <textarea name="atividades<?=$b;?>" id="atividades" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Última remuneração</label>
                                <input type="text" name="ultimaremuneracao<?=$b;?>" id="ultimaremuneracao" class="form-control"  maxlength="15"/>
                            </div>
                            <div class="col-md-8">
                                <label>Motivo da saída</label>
                                <input type="text" name="motivosaida<?=$b;?>" id="motivosaida" class="form-control"  maxlength="150" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Nome para referência</label>
                                <input type="text" name="referencia<?=$b;?>" id="referencia" class="form-control"  maxlength="150"/>
                            </div>
                            <div class="col-md-4">
                                <label>Telefone</label>
                                <input type="tel" name="telref<?=$b;?>" id="telref" class="form-control"  maxlength="15" />
                            </div>
                        </div>
                    </div>
                    <? } ?>
                </div>

                <div class="tab-pane" id="tab6">
				<? $i=1; $numcap = $det7->rowCount();?>
                <? while($cv7 = $det7->fetch(PDO::FETCH_ASSOC)){?>
                <h3>Curso <?=$i;?></h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Curso</label>
                            <input type="text" name="cursoextra<?=$i;?>" id="cursoextra<?=$i;?>" class="form-control" value="<?=$cv7['curso'];?>" maxlength="150" />
                        </div>
                        <div class="col-md-3">
                            <label>Instituição</label>
                            <input type="text" name="instextra<?=$i;?>" id="instextra<?=$i;?>" class="form-control" value="<?=$cv7['instituicao'];?>"  maxlength="50"/>
                        </div>
                        <div class="col-md-3">
                            <label>Conclusão. Exemplo: 02/02/2002</label>
                            <input type="text" name="dataconcextra<?=$i;?>" id="dataconcextra<?=$i;?>" class="form-control datepicker" value="<?=formataData($cv7['conclusao'], 'php');?>" />
                        </div>
                    </div>
                </div>
                <? $i++;}
					$extracap = 5 - $numcap;
					for($n=0;$n<$extracap;$n++){?>
                <h3>Curso <?=$i;?></h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Curso</label>
                            <input type="text" name="cursoextra<?=$i;?>" id="cursoextra<?=$i;?>" class="form-control" value="<?=$cv7['curso'];?>"  maxlength="150" />
                        </div>
                        <div class="col-md-3">
                            <label>Instituição</label>
                            <input type="text" name="instextra<?=$i;?>" id="instextra<?=$i;?>" class="form-control" value="<?=$cv7['instituicao'];?>" maxlength="50" />
                        </div>
                        <div class="col-md-3">
                            <label>Conclusão. Exemplo: 02/02/2002</label>
                            <input type="text" name="dataconcextra<?=$i;?>" id="dataconcextra<?=$i;?>" class="datepicker form-control" value="<?=$cv7['conclusao'];?>" />
                        </div>
                    </div>
                </div>
				<?	 $i++; }
				?>
                </div>

                <div class="tab-pane" id="tab7">
                  <div class="form-group">
                    <label>Como você soube da vaga disponível?</label>
                    <input type="text" name="comosoube" id="comosoube" class="form-control" value="<?=$cv8['sobreavaga'];?>"  maxlength="100"/>
                  </div>
                    
                  <div class="form-group">
                    <label>Comentários gerais</label>
                    <textarea name="comentarios" id="comentarios" class="form-control"><?=$cv8['comentarios'];?></textarea>
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
                </div>



                <ul class="pager wizard mt30">
                    <li class="previous"><a href="#">Anterior</a></li>
                    <li class="next"><a href="#">Próxima</a></li>
                    <input type="submit" class="btn btn-lg btn-success" value="Atualizar Currículo"  />
                    </form>
                </ul>

            </div>
        </div>
	</div>

<? } ?></div>

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
</body>
</html>