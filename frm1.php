<form name="frmCv" id="frmCv" method="post" action="<?=$_SERVER['PHP_SELF'];?>?acao=cadCv" onsubmit="return validafrmCv(this);">

<div class="form-group">

  <label>Nome</label>
  <input type="text" name="nome" id="nome" class="form-control" maxlength="200"/>

</div>

<div class="form-group">

  <div class="row">
    <div class="col-md-8">
      <label>E-mail</label>
      <input type="email" name="email" id="email" class="form-control" maxlength="100" />
    </div>

    <div class="col-md-4">
      <label>Gênero</label>
      <select name="genero" id="genero" class="form-control">
        <option value="">Selecione</option>
        <option value="Masculino">Masculino</option>
        <option value="Feminino">Feminino</option>
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
        <option value="Solteiro(a)">Solteiro(a)</option>
        <option value="Casado(a)">Casado(a)</option>
        <option value="Divorciado(a)">Divorciado(a)</option>
        <option value="Viúvo(a)">Viúvo(a)</option>
      </select>

    </div>

    <div class="col-md-4">
      <label>Data de nascimento</label>
      <input type="text" name="nascimento" id="nascimento" class="datepicker form-control" maxlength="10"/>
    </div>

  </div>

</div>

<div class="form-group">

  <div class="row">

    <div class="col-md-4">
      <label>Pessoa (PcD)</label>
      <select name="pcd" id="pcd" class="form-control">
        <option value="">Selecione</option>
        <option value="Sim">Sim</option>
        <option value="Não">Não</option>
      </select>

    </div>

    <div class="col-md-4">
      <label>Tipo de deficiência</label>
      <input type="text" name="deficiencia" id="deficiencia" class="form-control" maxlength="150"/>
    </div>

    

    <div class="col-md-4">
      <label>CID</label>
      <input type="text" name="cid" id="cid" class="form-control" maxlength="40"/>
    </div>

  </div>

</div>

<div class="form-group">

  <div class="row">

    <div class="col-md-6">
      <label>Tem filhos?</label>
      <select name="filhos" id="filhos" class="form-control">
        <option value="">Selecione</option>
        <option value="Sim">Sim</option>
        <option value="Não">Não</option>
      </select>

    </div>

    <div class="col-md-6">
      <label>Quantos</label>
      <input type="number" name="qtyfilhos" id="qtyfilhos" class="form-control" maxlength="2"/>
    </div>

  </div>

</div>

<div class="form-group">

  <div class="row">

    <div class="col-md-2">
      <label>CEP</label>
      <input type="text" name="cep" id="cep" class="form-control" onblur="pesquisacep(this.value);" />
    </div>

    <div class="col-md-8">
      <label>Rua</label>
      <input type="text" name="rua" id="rua" class="form-control" maxlength="250"/>
    </div>

    <div class="col-md-2">
      <label>Número</label>
      <input type="number" name="numero" id="numero" class="form-control" maxlength="6"/>
    </div>

  </div>

</div>

<div class="form-group">
  <label>Complemento (Quadra, Lote, Torre, etc)</label>
  <input type="text" name="complemento" id="complemento" class="form-control"maxlength="250" />
</div>

<div class="form-group">
  <div class="row">
    <div class="col-md-4">
      <label>Bairro</label>
      <input type="text" name="bairro" id="bairro" class="form-control" maxlength="50"/>
    </div>

    <div class="col-md-4">
      <label>Cidade</label>
      <input type="text" name="cidade" id="cidade" class="form-control" maxlength="50" />
    </div>

    <div class="col-md-4">
      <label>UF</label>
      <select class="form-control" name="uf" id="uf">
        <option value="">Selecione</option>
        <option value="AC">Acre</option>
        <option value="AL">Alagoas</option>
        <option value="AP">Amapá</option>
        <option value="AM">Amazonas</option>
        <option value="BA">Bahia</option>
        <option value="CE">Ceará</option>
        <option value="DF">Distrito Federal</option>
        <option value="ES">Espírito Santo</option>
        <option value="GO">Goiás</option>
        <option value="MA">Maranhão</option>
        <option value="MT">Mato Grosso</option>
        <option value="MS">Mato Grosso do Sul</option>
        <option value="MG">Minas Gerais</option>
        <option value="PA">Pará</option>
        <option value="PB">Paraíba</option>
        <option value="PR">Paraná</option>
        <option value="PE">Pernambuco</option>
        <option value="PI">Piauí</option>
        <option value="RJ">Rio de Janeiro</option>
        <option value="RN">Rio Grande do Norte</option>
        <option value="RS">Rio Grande do Sul</option>
        <option value="RO">Rondônia</option>
        <option value="RR">Roraima</option>
        <option value="SC">Santa Catarina</option>
        <option value="SP">São Paulo</option>
        <option value="SE">Sergipe</option>
        <option value="TO">Tocantins</option>
      </select>
    </div>

  </div>

</div>

<div class="form-group">
  <div class="row">
    <div class="col-md-4">
      <label>Telefone residencial</label>
      <input type="text" name="tel_res" id="tel_res" class="form-control" maxlength="15"/>
    </div>

    <div class="col-md-4">
      <label>Telefone celular</label>
      <input type="text" name="tel_cel" id="tel_cel" class="form-control" maxlength="15"/>
    </div>

    <div class="col-md-4">
      <label>Telefone comercial</label>
      <input type="tel" name="tel_com" id="tel_com" class="form-control" maxlength="15"/>
    </div>

  </div>
</div>

<div class="form-group">
  <label>Recados aos cuidados de:</label>
  <input type="text" name="recados" id="recados" class="form-control" maxlength="40"/>
</div>

<div class="form-group">
  <div class="row">
    <div class="col-md-6">
      <label>Naturalidade</label>
      <input type="text" name="naturalidade" id="naturalidade" class="form-control" maxlength="30"/>
    </div>

    <div class="col-md-6">
      <label>Nacionalidade</label>
      <input type="text" name="nacionalidade" id="nacionalidade" class="form-control" maxlength="30"/>
    </div>
  </div>

</div>

<div class="form-group">
  <div class="row">
    <div class="col-md-6">
      <label>Nome da mãe</label>
      <input type="text" name="mae" id="mae" class="form-control" maxlength="150"/>
    </div>

    <div class="col-md-6">
      <label>Nome do pai</label>
      <input type="text" name="pai" id="pai" class="form-control" maxlength="150"/>
    </div>
  </div>
</div>

