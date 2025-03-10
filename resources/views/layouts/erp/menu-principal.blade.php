@php
    $json_menu = file_get_contents('erp-menu-principal.json');
    $menuPrincipal = collect(json_decode($json_menu, true));

    $currentRoute = parse_url(url()->current(), PHP_URL_PATH);

    $seleccionadoNivel_1 = null;
    $seleccionadoNivel_2 = null;
    $seleccionadoNivel_3 = null;
    $seleccionadoNivel_4 = null;

    foreach ($menuPrincipal as $dataNivel_1) {
        if ($dataNivel_1['url'] === $currentRoute) {
            $seleccionadoNivel_1 = $dataNivel_1['id'];
        }

        foreach ($dataNivel_1['submenus'] as $dataNivel_2) {
            if ($dataNivel_2['url'] === $currentRoute) {
                $seleccionadoNivel_1 = $dataNivel_1['id'];
                $seleccionadoNivel_2 = $dataNivel_2['id'];
            }

            foreach ($dataNivel_2['submenus'] as $dataNivel_3) {
                if ($dataNivel_3['url'] === $currentRoute) {
                    $seleccionadoNivel_1 = $dataNivel_1['id'];
                    $seleccionadoNivel_2 = $dataNivel_2['id'];
                    $seleccionadoNivel_3 = $dataNivel_3['id'];
                }

                foreach ($dataNivel_3['submenus'] as $dataNivel_4) {
                    if ($dataNivel_4['url'] === $currentRoute) {
                        $seleccionadoNivel_1 = $dataNivel_1['id'];
                        $seleccionadoNivel_2 = $dataNivel_2['id'];
                        $seleccionadoNivel_3 = $dataNivel_3['id'];
                        $seleccionadoNivel_4 = $dataNivel_4['id'];
                    }
                }
            }
        }
    }
@endphp

<!--CONTENEDOR ASIDE-->
<aside class="contenedor_aside" :class="{ 'estilo_abierto_contenedor_aside': estadoAsideAbierto }"
    data-seleccionado-nivel-1="{{ $seleccionadoNivel_1 }}" data-seleccionado-nivel-2="{{ $seleccionadoNivel_2 }}"
    data-seleccionado-nivel-3="{{ $seleccionadoNivel_3 }}" data-seleccionado-nivel-4="{{ $seleccionadoNivel_4 }}">
    <!--CONTENEDOR NAV ICONOS-->
    <div class="contenedor_nav_iconos">
        <span x-on:click="toggleContenedorNavLinks" class="contenedor_menu_hamburguesa"><i
                class="fa-solid fa-bars"></i></span>
        <!--NIVEL 1-->
        <ul>
            @foreach ($menuPrincipal as $dataNivel_1)
                <li
                    :class="{
                        'nav_icono_seleccionado': seleccionadoNivel_1 ==
                            {{ $dataNivel_1['id'] }},
                        'no-hover': seleccionadoNivel_1 == {{ $dataNivel_1['id'] }}
                    }">
                    <a @click="toogleNivel_1($event, {{ $dataNivel_1['id'] }})"
                        @if (!count($dataNivel_1['submenus']) > 0) href="{{ route($dataNivel_1['ruta']) }}" @endif>
                        <i class="{{ $dataNivel_1['icono'] }}"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!--CONTENEDOR NAV LINKS-->
    <div class="contenedor_nav_links" :class="{ 'estilo_abierto_contenedor_nav_links': estadoNavAbierto }">
        <div class="contenedor_logo">
            <a href="#">
                <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/logos/logo.svg"
                    alt="">
            </a>
        </div>

        <!--SIDEBAR NAV-->
        <nav class="sidebar_nav">
            <div class="sidebar_scroll">
                <!--NIVEL 1-->
                <ul class="nivel_1">
                    @foreach ($menuPrincipal as $dataNivel_1)
                        @if (count($dataNivel_1['submenus']) > 0)
                            <!--NIVEL 2-->
                            <ul class="submenu1"
                                :class="{ 'ocultar_nivel': seleccionadoNivel_1 !== {{ $dataNivel_1['id'] }} }">
                                @foreach ($dataNivel_1['submenus'] as $dataNivel_2)
                                    <li>
                                        <span class="contenedor_a"
                                            :class="{
                                                'sidebar_nav_seleccionado': seleccionadoNivel_2 ===
                                                    {{ $dataNivel_2['id'] }},
                                                'no-hover': seleccionadoNivel_2 == {{ $dataNivel_2['id'] }}
                                            }">
                                            <a @click.stop="toogleNivel_2($event, {{ $dataNivel_2['id'] }})"
                                                @if (!count($dataNivel_2['submenus']) > 0) href="{{ route($dataNivel_2['ruta']) }}" @endif>
                                                <i class="{{ $dataNivel_2['icono'] }}"></i>
                                                {{ $dataNivel_2['nombre'] }}
                                            </a>
                                            @if (count($dataNivel_2['submenus']) > 0)
                                                <i class="fa-solid fa-sort-down"></i>
                                            @endif
                                        </span>


                                        @if (count($dataNivel_2['submenus']) > 0)
                                            <!--NIVEL 3-->
                                            <ul class="nivel_2"
                                                :class="{ 'ocultar_nivel': seleccionadoNivel_2 !== {{ $dataNivel_2['id'] }} }">
                                                @foreach ($dataNivel_2['submenus'] as $dataNivel_3)
                                                    <li>
                                                        <span class="contenedor_a"
                                                            :class="{
                                                                'sidebar_item_seleccionado': seleccionadoNivel_3 ===
                                                                    {{ $dataNivel_3['id'] }}
                                                            }">
                                                            <a @click.stop="toogleNivel_3($event, {{ $dataNivel_3['id'] }})"
                                                                @if (!count($dataNivel_3['submenus']) > 0) href="{{ route($dataNivel_3['ruta']) }}" @endif>
                                                                <span class="punto_item"><i class="fa-solid fa-circle"></i></span>
                                                                {{ $dataNivel_3['nombre'] }}
                                                            </a>
                                                            @if (count($dataNivel_3['submenus']) > 0)
                                                                <i class="fa-solid fa-sort-down"></i>
                                                            @endif
                                                        </span>

                                                        @if (count($dataNivel_3['submenus']) > 0)
                                                            <!--NIVEL 4-->
                                                            <ul class="submenu3"
                                                                :class="{
                                                                    'ocultar_nivel': seleccionadoNivel_3 !==
                                                                        {{ $dataNivel_3['id'] }}
                                                                }">
                                                                @foreach ($dataNivel_3['submenus'] as $dataNivel_4)
                                                                    <li>
                                                                        <span class="contenedor_a"
                                                                            :class="{
                                                                                'sidebar_item_seleccionado': seleccionadoNivel_4 ===
                                                                                    {{ $dataNivel_4['id'] }}
                                                                            }">
                                                                            <a @click.stop="toogleNivel_4($event, {{ $dataNivel_4['id'] }})"
                                                                                @if (!count($dataNivel_4['submenus']) > 0) href="{{ route($dataNivel_4['ruta']) }}" @endif>
                                                                                <span class="punto_item"><i class="fa-solid fa-circle"></i></span>
                                                                                {{ $dataNivel_4['nombre'] }}
                                                                            </a>
                                                                            @if (count($dataNivel_4['submenus']) > 0)
                                                                                <i class="fa-solid fa-sort-down"></i>
                                                                            @endif
                                                                        </span>

                                                                        <!--NIVEL 5-->
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</aside>
