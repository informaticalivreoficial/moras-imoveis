<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\{
    Settings,
};
use App\Livewire\Dashboard\Users\{
    Time,
    Users,
    ViewUser,
    Form,
};
use App\Livewire\Dashboard\Permissions\Index as PermissionIndex;
use App\Livewire\Dashboard\Roles\Index as RoleIndex;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    ConfigController,
    EmailController,
    PropertyController,
    TemplateController,
    UserController
};
use App\Http\Controllers\Web\{
    FeedController,
    FilterController,
    SendEmailController,
    Webcontroller
};
use App\Livewire\Dashboard\Properties\Properties;
use App\Livewire\Dashboard\Properties\PropertyForm;
use App\Livewire\Dashboard\Slides\SlideForm;
use App\Livewire\Dashboard\Slides\Slides;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {
    /** Página Inicial */
    Route::get('/', [WebController::class, 'home'])->name('home');

//     /** FEED */
//     Route::get('feed', [FeedController::class, 'feed'])->name('feed');
//     Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
//     Route::get('/sitemap', [WebController::class, 'sitemap'])->name('sitemap');

     /** Página de Compra - Específica de um imóvel */
     //Route::match(['get', 'post'],'/imoveis/quero-comprar/{slug}', [WebController::class, 'buyProperty'])->name('buyProperty');

     /** Página de Locaçãp - Específica de um imóvel */
     //Route::get('imoveis/quero-alugar/{slug}', [WebController::class, 'rentProperty'])->name('rentProperty');
     Route::get('imoveis/{slug}', [WebController::class, 'Property'])->name('property');
     Route::get('imoveis', [WebController::class, 'Properties'])->name('properties');

//     /** Lista todos os imóveis */
//     Route::get('/imoveis/{type}', [WebController::class, 'propertyList'])->name('propertyList');

//     /** Página de Experiências - Específica de uma categoria */
//     Route::get('/experiencias/{slug}', [FilterController::class, 'experienceCategory'])->name('experienceCategory');

//     /** Pesquisa */
//     Route::get('/pesquisar-imoveis', [SiteController::class, 'pesquisaImoveis'])->name('pesquisar-imoveis');
//     Route::match(['post', 'get'], '/pesquisa', [SiteController::class, 'pesquisaImoveis'])->name('pesquisa');

//     //CLIENTE
//     //Route::get('/atendimento', [SendEmailController::class, 'contact'])->name('contact');
//     Route::post('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
//     Route::get('/sendNewsletter', [SendEmailController::class, 'sendNewsletter'])->name('sendNewsletter');
//     Route::get('/sendReserva', [SendEmailController::class, 'sendReserva'])->name('sendReserva');

//     //****************************** Blog ***********************************************/
//     Route::get('/blog/artigo/{slug}', [SiteController::class, 'artigo'])->name('blog.artigo');
//     Route::get('/blog/categoria/{slug}', [SiteController::class, 'categoria'])->name('blog.categoria');
//     Route::get('/blog/artigos', [SiteController::class, 'artigos'])->name('blog.artigos');    
//     Route::match(['get', 'post'],'/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

//     //****************************** Notícias ***********************************************/
//     Route::get('/noticia/{slug}', [SiteController::class, 'noticia'])->name('noticia');
//     Route::get('/noticias/categoria/{slug}', [SiteController::class, 'categoria'])->name('noticia.categoria');
//     Route::get('/noticias', [SiteController::class, 'noticias'])->name('noticias'); 

//     //****************************** Páginas ***********************************************/
//     Route::get('/pagina/{slug}', [SiteController::class, 'pagina'])->name('pagina');

//     //FILTROS
//     Route::post('main-filter/search', [FilterController::class, 'search'])->name('main-filter.search');
//     Route::post('main-filter/categoria', [FilterController::class, 'categoria'])->name('main-filter.categoria');
//     Route::post('main-filter/tipo', [FilterController::class, 'tipo'])->name('main-filter.tipo');
//     Route::post('main-filter/bairro', [FilterController::class, 'bairro'])->name('main-filter.bairro');
//     Route::post('main-filter/dormitorios', [FilterController::class, 'dormitorios'])->name('main-filter.dormitorios');
//     Route::post('main-filter/suites', [FilterController::class, 'suites'])->name('main-filter.suites');
//     Route::post('main-filter/banheiros', [FilterController::class, 'banheiros'])->name('main-filter.banheiros');
//     Route::post('main-filter/garagem', [FilterController::class, 'garagem'])->name('main-filter.garagem');
//     Route::post('main-filter/price-base', [FilterController::class, 'priceBase'])->name('main-filter.priceBase');
//     Route::post('main-filter/price-limit', [FilterController::class, 'priceLimit'])->name('main-filter.priceLimit');
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {

    Route::get('/', Dashboard::class)->name('admin');
    Route::get('configuracoes', Settings::class)->name('settings');

    //******************************* Sitemap *********************************************/
    // Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    
    // Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    // Route::get('listas/email/set-status', [NewsletterController::class, 'emailSetStatus'])->name('emails.emailSetStatus');
    // Route::get('listas/email/delete', [NewsletterController::class, 'emailDelete'])->name('emails.delete');
    // Route::delete('listas/email/deleteon', [NewsletterController::class, 'emailDeleteon'])->name('emails.deleteon');
    // Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    // Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    // Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    // Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    //******************* Templates ************************************************/
    Route::get('templates/set-status', [TemplateController::class, 'templateSetStatus'])->name('templates.templateSetStatus');
    Route::get('templates/delete', [TemplateController::class, 'delete'])->name('templates.delete');
    Route::delete('templates/deleteon', [TemplateController::class, 'deleteon'])->name('templates.deleteon');
    Route::put('templates/{id}', [TemplateController::class, 'update'])->name('templates.update');
    Route::get('templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::get('templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('templates/store', [TemplateController::class, 'store'])->name('templates.store');
    Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');

    /** Imóveis */
    Route::get('imoveis/{property}/editar', PropertyForm::class)->name('property.edit');
    Route::get('imoveis/cadastrar', PropertyForm::class)->name('properties.create');
    Route::get('imoveis', Properties::class)->name('properties.index');

    //*********************** Slides *********************************************/
    Route::get('slides/{slide}/editar', SlideForm::class)->name('slides.edit');
    Route::get('slides/cadastrar', SlideForm::class)->name('slides.create');
    Route::get('slides', Slides::class)->name('slides.index');

    //*********************** Usuários *******************************************/
    Route::get('/cargos', RoleIndex::class)->name('admin.roles');
    Route::get('/permissoes', PermissionIndex::class)->name('admin.permissions');

    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{userId}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{user}/visualizar', ViewUser::class)->name('users.view');  

    Route::view('posts/create', 'admin.posts.create');

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

});


// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
