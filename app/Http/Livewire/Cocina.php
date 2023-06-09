<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Mercancia as MercanciaModel;
use App\Models\Producto as ProductoModel;
use App\Models\ElaboracionesMercancias as ElaboracionesMercanciasModel;
use App\Models\Elaboraciones as ElaboracionesModel;

class Cocina extends Component
{
    /*ingredientes*/
    public $miIngrediente;

    public $mercancias;
    public $productoReceta;

    /*productos*/
    public $miProducto;
    public $productos;
    public $productoSeleccionado;
    public $recetaProductoSeleccionado;

    public $verEmplatado;

    /*Crear platos*/
    public $modalVisibleP; 

    public $nombreP;
    //poner la variable nombreP como nombre 
    public $recetaE;

    public $idFamiliaP;
    //buscar idElaboración //crear previamente la elaboración
    public $descripcionP;
    public $idTipoP;
    public $imgP;
    public $precioP;

    //idmercancia seleccionada
    //todas las mercancias
    public $idMercanciaEm;
    public $cantidadMercanciaEm;
    public $listElabMerc;    

    protected $listeners = ['cargarEmplatado','cargarProductos'];

    public function mount(){
        $this->verEmplatado=false;
        $this->mercancias=MercanciaModel::all();
        $this->productos=ProductoModel::all();
    }

    public function verModalPlato($ver)
    {
        $this->modalVisibleP=$ver;
    }

    public function updatedIdMercanciaEm()
    {
        if(strpos($this->idMercanciaEm,','))
        {
            $parteCantMerc = explode(" ", $this->idMercanciaEm);
            $object=[3];
            $object['id'] = (sizeof($this->listElabMerc));
            $object['cantidad'] = $parteCantMerc[0];
            $object['mercancia'] = str_replace(',', "", $parteCantMerc[1]);
            //dd( $object);
            $this->listElabMerc=$object;
            //dd($this->listElabMerc);
            $this->idMercanciaEm="";            
        }
    }

    //searchs
    public function updatedMiIngrediente()
    {
        $this->productos=ProductoModel::all();
        if($this->miIngrediente!=null){
            return $this->mercancias = MercanciaModel::where('nombre', 'like', '%' . $this->miIngrediente . '%')->get();

        }else{
            $this->mercancias=MercanciaModel::all();
        }
    }

    public function updatedMiProducto()
    {
        if($this->miProducto!=null){
            return $this->productos = ProductoModel::where('nombre', 'like', '%' . $this->miProducto . '%')->get();

        }else{
            $this->productos=ProductoModel::all();
        }
    }

    //clicks
    public function cargarProductos($idMercancia)
    {
        $this->productos = [];
        //todas las mercancias en mercanciasElab con su respectivo idElaboracion
        $mercanciasElab = ElaboracionesMercanciasModel::where('idMercancia', $idMercancia)->get();

        if($mercanciasElab!=null)
        {
            foreach ($mercanciasElab as $receta)
            {
                //dd($receta["idElaboracion"]);
                $array = ProductoModel::where('idElaboraciones', $receta["idElaboracion"])->get();
                $this->productos[] = $array[0];
            }
        }


        /*if($mercanciasElab!=null){
            //coger las elaboraciones distintas que puede tener mi producto seleccionado
            $recetasElaMer=$mercanciasElab->groupBy('idElaboracion');

            foreach ($recetasElaMer as $receta){
                //coger mis productos que tengan ese id de elaboración
                $this->productoReceta = ProductoModel::where('idElaboraciones', $receta[0]->idElaboracion)->get();

                $this->productos[] = $this->productoReceta[0];

            }
        }*/
    }

    public function cargarEmplatado($idProducto)
    {
        $this->productoSeleccionado = ProductoModel::where('id', $idProducto)->get()->first();
        $receta= ElaboracionesModel::where('id', $this->productoSeleccionado->id)->get()->first();

        // Dividir la variable por cada coma y obtener un array
        $this->recetaProductoSeleccionado = explode(",", $receta->receta);

        $this->verEmplatado=true;
    }

    public function cerrarEmplatado()
    {
        $this->verEmplatado=false;
    }

    public function render()
    {
        return view('livewire.cocina');
    }
}
