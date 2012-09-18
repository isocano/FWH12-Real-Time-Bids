<div class="row">
	<form action="<?php echo $this->config->item('base_url');?>auction/add" method="post" enctype="multipart/form-data"> 
 		<label>Nombre del producto</label>
	 	<input type="text" name="lot_name" placeholder="Nombre" />
	  
	 	<label>Descripción</label>
		<input type="text" name="description" placeholder="Descripción" />
	  
	  	<label>Precio</label>
	  	<input type="text" name="price" placeholder="Precio" />
	 
		<input name="image" id="upfile" type="file"/>
	  
	  <label>Address</label>
	  <input type="text" class="twelve" placeholder="Street" />
	  <div class="row">
	    <div class="six columns">
	      <input type="text" placeholder="City" />
	    </div>
	    <div class="three columns">
	      <input type="text" placeholder="State" />
	    </div>
	    <div class="three columns">
	      <input type="text" placeholder="ZIP" />
	    </div>
	  </div>  
	</form>  

</div>	