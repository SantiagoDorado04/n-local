<?php

namespace App\Http\Controllers;

class WhatsAppController extends Controller
    {
        public $name = "Santiago";
        public $phone = 573173718358;


        public function sendOrderByWhatsApp()
        {
            // Lógica para construir el mensaje de WhatsApp
            $mensajeWhatsApp = "Hola, mi nombre es {$this->name}";

            // foreach ($this->cartItems as $item) {
            //     // Accede a las claves del array de manera segura
            //     $productName = $item['name'] ?? '';
            //     $quantity = $item['qty'] ?? '';
            //     $price = $item['price'] ?? '';
            //     $subtotal = $item['subtotal'] ?? '';
            //     $image = isset($item['model']['image']) ? asset('assets/imgs/products') . '/' . $item['model']['image'] : '';

            //     // Agrega la información al mensaje de WhatsApp
            //     $mensajeWhatsApp .= "\n{$productName} - Cantidad: {$quantity} - Precio unitario: {$price} - Precio total: {$subtotal} - Imagen: {$image}";
            // }

            // Agrega el total del carrito al mensaje
            // $mensajeWhatsApp .= "\nTotal: {$this->cartTotal}";

            // Número de teléfono para el enlace de WhatsApp (reemplaza con tu número real)
            $phoneNumber = '573188332243';

            // Enlace de WhatsApp con el número de teléfono y mensaje
            $whatsAppLink = "https://wa.me/{$phoneNumber}?text=" . urlencode($mensajeWhatsApp);

            // Muestra un mensaje de éxito a través de Livewire
            session()->flash('success_message', 'Tu pedido ha sido enviado con éxito!');

            // Emite un evento de Livewire para abrir el enlace de WhatsApp
            $this->dispatchBrowserEvent('openWhatsApp', [
                'whatsAppLink' => $whatsAppLink,
            ]);

            // Limpia el formulario
            $this->name = '';
            $this->phone = '';
        }
    }
