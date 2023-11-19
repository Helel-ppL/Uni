import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/cuenta/auth.service';
import { environment } from 'src/environments/environment.development';

@Component({
  selector: 'app-lotes',
  templateUrl: './lotes.component.html',
  styleUrls: ['./lotes.component.css']
})
export class LotesComponent implements OnInit {
  url = environment.apiUrl
  id = ''
  i = 0

  carrito: Carrito[] = []

  productosCargados: any

  constructor(private http: HttpClient, private authService: AuthService) { }

  ngOnInit(): void {
    this.http.post(this.url + '/productos/get-all_productos.php', { 'session': this.authService.sessionId }).subscribe(
      (response: any) => { this.productosCargados = response }
    );
    // console.log(this.productosCargados)
  }

  enviarDatos() {
    let sent = {
      'session': this.authService.sessionId,
      'id': this.id,
      'producto': this.productos.producto, //SI LOGRO UN ARRAY CON CADA UNO DE LOS DATOS PUSHEADOS, ENTONCES LOGRARÍA HABILITAR UN FORMULARIO MÚLTIPLE.
      'precio': this.productos.precio,
      'cantidad': this.productos.cantidad,
      'cliente': this.productos.cliente
    }

    console.log('sent: ', sent)
    this.http.post(this.url + '/form-lotes.php', sent).subscribe(
      (response: any) => {
        alert(response.message);
        console.log(response);
        if (response.result == 'success') {
          this.carrito = []
          this.productos = {producto: [], precio: [], cantidad:[], cliente:[]};
        }
      }
    );

  }

  productos: Productos = {
    producto: [],
    precio: [],
    cantidad: [],
    cliente: []
  };

  producto: Producto = {
    id: '',
    precio: 0,
    cantidad: 0,
    cliente: ''
  };

  siguienteProducto() {
    // console.log('a', this.carrito)
    // console.log('b', this.productosCargados)
    // console.log('c', this.productos)
    // console.log('d', this.producto)

    if (this.productos.producto.includes(this.producto.id)) {
      alert("Intentó registrar un producto que ya está en el carrito.")
      return
    }

    if (this.producto.id == "") {
      alert("Seleccione un carro.")
      return
    }

    if (this.producto.precio == 0 || this.producto.precio <= 0) {
      alert("Ingrese un precio válido.")
      return
    }

    if (this.producto.precio == 0 || this.producto.cantidad <= 0) {
      alert("Ingrese una cantidad de producto válida.")
      return
    }

    if (this.producto.cliente == "") {
      alert("Ingrese un cliente cliente")
      return
    }

    this.productos.producto.push(this.producto.id);
    this.productos.precio.push(this.producto.precio);
    this.productos.cantidad.push(this.producto.cantidad);
    this.productos.cliente.push(this.producto.cliente);

    this.carrito.push({
      id: this.producto.id,
      nombreR: this.productosCargados.find((prdct: any) => prdct.id == this.producto.id).nombre,
      mecanicoR: this.productosCargados.find((prdct: any) => prdct.id == this.producto.id).mecanico,
      cantidadR: this.producto.cantidad,
      fvR: this.producto.cliente,
      precioR: this.producto.precio
    })

    this.producto = {
      id: '',
      precio: 0,
      cantidad: 0,
      cliente: ''
    }

    // console.log('A: ',prd.id, 'B: ', this.productos.producto[this.i])

    this.i++

  }

  // actualizarLista(index: number, productos: any): number{
  //   console.log(this.carrito)
  //   return index
  // }
}

interface Carrito {
  id: string,
  nombreR: string,
  mecanicoR: string,
  cantidadR: number,
  fvR: string,
  precioR: number
}

interface Productos{
  producto: string[],
    precio: number[],
    cantidad: number[],
    cliente: string[]
}

interface Producto{
    id: string,
    precio: number,
    cantidad: number,
    cliente: string
}