<div>
    <form method="post">                             
        <div class="form-group">
            <label>Alugar ou Comprar?</label>
            <select class="search-fields loadtipo" name="tipo" id="tipo">
                <option value="1">Alugar</option>
                <option value="0">Comprar</option>
            </select>
        </div>
        <div class="form-group">
            <label>Escolha a Cidade</label>
            <select class="search-fields loadcidadeFiltro" name="cidade" id="cidade">
            <option selected>Escolha a Cidade</option> 
            <option value="'.$cidade['cidade_id'].'">'.$cidade['cidade_nome'].'</option>
        </select>
        </div>  
        <div class="form-group">
            <div class="selectBairro">
                <select class="search-fields j_loadbairros" name="bairro_id" id="bairro" disabled>
                    <option value="" selected>Selecione o Bairro</option>
                </select>
            </div>
        </div>                        
        <div class="form-group">
            <label>Valores</label>
            <div class="selectValores">
                <select class="search-fields loadvalores" name="valores" id="valores">
                    <option value="" selected>Imóvel até</option>
                    <option value="300000">R$300.000</option>
                    <option value="450000">R$450.000</option>
                    <option value="600000">R$600.000</option>
                    <option value="750000">R$750.000</option>
                    <option value="900000">R$900.000</option>
                    <option value="1500000">R$1.500.000</option>
                    <option value="2000000">R$2.000.000</option>
                    <option value="2500000">R$2.500.000</option>
                    <option value="3000000">R$3.000.000</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Quartos</label>
            <select class="search-fields loaddormitorios" name="dormitorios" id="dormitorios">
                <option value="1">1+</option>
                <option value="2">2+</option>
                <option value="3">3+</option>
                <option value="4">4+</option>
                <option value="5">5+</option>
                <option value="">Todos</option>
            </select>
        </div>

        <div class="form-group mb-0">                
            <button class="search-button">Buscar Imóveis</button>
        </div>
    </form>
</div>
