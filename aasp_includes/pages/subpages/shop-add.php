<?php
/*
             _____           ____
            |   __|_____ _ _|    \ ___ _ _ ___
            |   __|     | | |  |  | -_| | |_ -|
            |_____|_|_|_|___|____/|___|\_/|___|
     Copyright (C) 2013 EmuDevs <http://www.emudevs.com/>
 */
?>
<?php $page = new page; ?>
<div class="box_right_title"><?php echo $page->titleLink(); ?> &raquo; Add itens</div>
<table width="100%">
        <tr valign="top">
             <td style="text-align: left; width: 300px;"><h3>Item único</h3>
             <p/>
             ID<br/>
             <input type="text" style="width: 200px;" id="addsingle_entry"/><br/>
             Preço<br/>
             <input type="text" style="width: 200px;" id="addsingle_price"/><br/>
             Loja<br/>
             <select style="width: 205px;" id="addsingle_shop">
               <option value="vote">Loja de Votação</option>
               <option value="donate">Loja de Doação</option>
             </select><br/>
             <input type="submit" value="Add" onclick="addSingleItem()"/>
             </td>
             <td style="text-align: left; width: 300px;"><h3>Vários itens</h3>
             <p/>
             Nível dos itens<br/>
             <select style="width: 140px;" id="addmulti_il_from">
                      <?php for ($i = 1; $i <= $GLOBALS['maxItemLevel']; $i++) {
						echo "<option>".$i."</option>";
					} ?>
             </select>
             e
             <select style="width: 140px;" id="addmulti_il_to">
                      <?php for ($i = $GLOBALS['maxItemLevel']; $i >= 1; $i--) {
						echo "<option>".$i."</option>";
					} ?>
             </select><br/>
             Preço<br/>
             <input type="text" style="width: 200px;" id="addmulti_price"/><br/>
             Qualidade<br/>
             <select style="width: 205px;" id="addmulti_quality">
               <option value="all">Todos</option>
               <option value="0">Ruim</option>
               <option value="1">Comun</option>
               <option value="2">Incomun</option>
               <option value="3">Raro</option>
               <option value="4">Épico</option>
               <option value="5">Legendário</option>
             </select><br/>
             Tipo<br/>
             <select id="addmulti_type" style="width: 205px;">
               <option value="all">Todos</option>
               <option value="0">Consumível</option>
               <option value="1">Recipiente</option>
               <option value="2">Armas</option>
               <option value="3">Jóias</option>
               <option value="4">Armadura</option>
               <option value="15">Diversos</option>
                                <option value="16">Glyph</option>
                                <option value="15-5">Montaria</option>
                                <option value="15-2">Animal de Estimação</option>
             </select>	
             <br/>
             Loja<br/>
             <select style="width: 205px;" id="addmulti_shop">
               <option value="vote">Loja de Votação</option>
               <option value="donate">Loja de Doação</option>
             </select><br/>
             <input type="submit" value="Add" onclick="addMultiItem()"/>
             </td>
        </tr>
</table>