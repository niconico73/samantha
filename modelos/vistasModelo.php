<?php
	class vistasModelo{

		/*---------- Modelo obtener vistas ----------*/
		protected static function obtener_vistas_modelo($vistas){
			$listaBlanca=["dashboard","user-new","user-list","user-search","user-update","product-new","product-list","product-search","product-update","product-sold","product-info","product-image","cashier-new","cashier-list","cashier-search", "cashier-update","category-new","category-list","category-search","category-update","product-category","provider-new","provider-list","provider-search","provider-update","company","client-new","client-list","client-search","client-update","movement-new","movement-list","movement-search","shop-new","shop-list","shop-search","shop-detail","kardex","kardex-search","kardex-product","kardex-detail","sale-new","sale-list","sale-search-date","sale-search-code","sale-detail","sale-pending","return-list","return-search","product-expiration","product-minimum","report-sales","report-inventory"];
			if(in_array($vistas, $listaBlanca)){
				if(is_file("./vistas/contenidos/".$vistas."-view.php")){
					$contenido="./vistas/contenidos/".$vistas."-view.php";
				}else{
					$contenido="404";
				}
			}elseif($vistas=="login" || $vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}

	}
