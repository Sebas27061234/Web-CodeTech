<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function sections(){
        $nav = [
            [
                "nombre" => "Blog",
                "icono" => "ti-app-window",
                "submenu" => true,
                "items" => [
                    [
                        "nombre" => "Autores",
                        "url" => route('admin.blog.autor.index'),
                    ],
                    [
                        "nombre" => "Categorias",
                        "url" => route('admin.blog.categoria.index'),
                    ],
                    [
                        "nombre" => "Posts",
                        "url" => route('admin.blog.posts.index'),
                    ],
                    [
                        "nombre" => "Videos",
                        "url" => route('admin.blog.video.index'),
                    ]
                ]
            ],
            [
                "nombre" => "Tienda",
                "icono" => "ti-building-store",
                "submenu" => true,
                "items" => [
                    [
                        "nombre" => "Categorias",
                        "url" => route("admin.tienda.categoria.index"),
                    ],
                    [
                        "nombre" => "Productos",
                        "url" => route('admin.tienda.productos.index'),
                    ],
                ]
            ],
            [
                "nombre" => "Cursos",
                "icono" => "ti-school",
                "submenu" => true,
                "items" => [
                    [
                        "nombre" => "Autores",
                        "url" => route("admin.cursos.autor.index"),
                    ],
                    [
                        "nombre" => "Categorias",
                        "url" => route("admin.cursos.categoria.index"),
                    ],
                    [
                        "nombre" => "Cursos",
                        "url" => route("admin.cursos.cursos.index"),
                    ],
                ]
            ],
            [
                "nombre" => "Compras",
                "icono" => "ti-credit-card",
                "url" => "",
                "submenu" => false,
            ],
            [
                "nombre" => "Promociones",
                "icono" => "ti-basket-discount",
                "url" => "",
                "submenu" => false,
            ],
            [
                "nombre" => "Cupones",
                "icono" => "ti-message-2-dollar",
                "url" => "",
                "submenu" => false,
            ],
            [
                "nombre" => "Usuarios",
                "icono" => "ti-users",
                "url" => "",
                "submenu" => false,
            ],
        ];
        return $nav;
    }
}
