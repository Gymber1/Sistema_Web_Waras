<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarruselAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin_global' => true]);
    }

    public function test_pagina_carrusel_carga(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/web-config/carrusel')
            ->assertOk()
            ->assertSee('Carrusel del Portal')
            ->assertSee('Pinacoteca');
    }

    public function test_guardar_oculta_las_no_marcadas(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/web-config/carrusel', [
                'visibles' => ['biblioteca', 'fototeca', 'koha'],
            ])
            ->assertRedirect();

        $this->assertEqualsCanonicalizing(
            ['efemerides', 'musicoteca', 'pinacoteca'],
            SiteSetting::carruselOcultos()
        );
        $this->assertTrue(SiteSetting::carruselVisible('biblioteca'));
        $this->assertFalse(SiteSetting::carruselVisible('musicoteca'));
    }

    public function test_home_solo_muestra_las_visibles(): void
    {
        SiteSetting::set('carrusel_hidden', json_encode(['musicoteca', 'pinacoteca', 'efemerides']));

        $this->get('/')
            ->assertOk()
            ->assertSee('Catálogo KOHA', false)
            ->assertDontSee('>Musicoteca<', false)
            ->assertDontSee('>Pinacoteca<', false);
    }

    public function test_no_permite_ocultarlas_todas(): void
    {
        SiteSetting::set('carrusel_hidden', json_encode([]));

        $this->actingAs($this->admin())
            ->post('/admin/web-config/carrusel', ['visibles' => []])
            ->assertSessionHasErrors('visibles');

        $this->assertSame([], SiteSetting::carruselOcultos());
    }

    public function test_header_marca_sesion_para_ajustar_el_menu(): void
    {
        // Con sesion el menu lleva dos botones mas; la clase activa el ancho
        // extra y el breakpoint propio, sin los cuales se tapaba el logo.
        $this->get('/')->assertOk()->assertDontSee('header-auth');

        $this->actingAs($this->admin())
            ->get('/')
            ->assertOk()
            ->assertSee('header-auth');
    }

    public function test_menu_incluye_waras_editorial(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Waras Editorial')
            ->assertSee('/biblioteca/editorial');
    }

    public function test_koha_usa_url_por_defecto_si_no_se_configura(): void
    {
        $this->assertSame(SiteSetting::KOHA_URL_DEFAULT, SiteSetting::kohaUrl());

        $this->get('/')->assertOk()->assertSee(SiteSetting::KOHA_URL_DEFAULT, false);
    }

    public function test_se_puede_cambiar_la_url_de_koha(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/web-config/carrusel', [
                'visibles' => ['biblioteca', 'koha'],
                'koha_url' => 'https://catalogo.ejemplo.pe/opac',
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertSame('https://catalogo.ejemplo.pe/opac', SiteSetting::kohaUrl());
        $this->get('/')->assertOk()->assertSee('https://catalogo.ejemplo.pe/opac', false);
    }

    public function test_url_de_koha_invalida_es_rechazada(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/web-config/carrusel', [
                'visibles' => ['biblioteca'],
                'koha_url' => 'no-es-una-url',
            ])
            ->assertSessionHasErrors('koha_url');

        $this->assertSame(SiteSetting::KOHA_URL_DEFAULT, SiteSetting::kohaUrl());
    }

    public function test_url_vacia_vuelve_al_valor_por_defecto(): void
    {
        SiteSetting::set('carrusel_koha_url', 'https://otro.ejemplo.pe');

        $this->actingAs($this->admin())
            ->post('/admin/web-config/carrusel', [
                'visibles' => ['biblioteca'],
                'koha_url' => '',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame(SiteSetting::KOHA_URL_DEFAULT, SiteSetting::kohaUrl());
    }

    public function test_requiere_sesion_admin(): void
    {
        $this->get('/admin/web-config/carrusel')->assertRedirect();
    }
}
