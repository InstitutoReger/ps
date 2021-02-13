<div class="form-group">
	<div class="row">
		<div class="col-md-4">
			<label>RG</label>
            <input type="number" name="rg" id="rg" class="form-control" maxlength="20" />
        </div>

		<div class="col-md-4">
			<label>Órgão emissor</label>
            <input type="text" name="emissor" id="emissor" class="form-control" maxlength="10" />
        </div>

		<div class="col-md-4">
            <label>UF</label>
               <select class="form-control" name="ufrg" id="ufrg">
                  <option value="">Selecione</option>
                  <option value="AC">Acre</option><option value="AL">Alagoas</option><option value="AP">Amapá</option><option value="AM">Amazonas</option><option value="BA">Bahia</option><option value="CE">Ceará</option><option value="DF">Distrito Federal</option><option value="ES">Espírito Santo</option><option value="GO">Goiás</option><option value="MA">Maranhão</option><option value="MT">Mato Grosso</option><option value="MS">Mato Grosso do Sul</option><option value="MG">Minas Gerais</option><option value="PA">Pará</option><option value="PB">Paraíba</option><option value="PR">Paraná</option><option value="PE">Pernambuco</option><option value="PI">Piauí</option><option value="RJ">Rio de Janeiro</option><option value="RN">Rio Grande do Norte</option><option value="RS">Rio Grande do Sul</option><option value="RO">Rondônia</option><option value="RR">Roraima</option><option value="SC">Santa Catarina</option><option value="SP">São Paulo</option><option value="SE">Sergipe</option><option value="TO">Tocantins</option>
                  </select>
        </div>
    </div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-5">
			<label>CPF</label>
            <input type="number" name="cpf" id="cpf" class="form-control" onblur="validarCPF(this);" />
        </div>

		<div class="col-md-5">
			<label>CNH</label>
            <input type="text" name="cnh" id="cnh" class="form-control"  maxlength="15" />
        </div>

		<div class="col-md-2">
            <label>Categoria</label>
            <input type="text" name="categoria" id="categoria" class="form-control"  maxlength="5" />
        </div>
    </div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-4">
			<label>CTPS</label>
            <input type="text" name="ctps" id="ctps" class="form-control" maxlength="15" />
        </div>

		<div class="col-md-4">
			<label>Série</label>
            <input type="text" name="serie" id="serie" class="form-control" maxlength="20" />
        </div>

		<div class="col-md-4">
            <label>PIS/PASEP</label>
            <input type="text" name="pispasep" id="pispasep" class="form-control" maxlength="15" />
        </div>
    </div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-6">
			<label>Certificado de reservista</label>
            <input type="text" name="reservista" id="reservista" class="form-control" maxlength="10" />
        </div>

        <div class="col-md-6">
			<label>Possui conta corrente na Caixa Econômica Federal?</label>
			<select name="conta" id="conta" class="form-control">
				<option value="">Selecione</option>
                <option value="Sim">Sim</option>
                <option value="Não">Não</option>
            </select>
        </div>
    </div>
</div>