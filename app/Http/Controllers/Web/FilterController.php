<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\Seo;

class FilterController extends Controller
{
    protected $tenant;
    protected $seo;

    public function __construct()
    {
        $this->seo = new Seo();
    }

    public function search(Request $request)
    {
        session()->remove('categoria');
        session()->remove('tipo');
        session()->remove('bairro');
        session()->remove('dormitorios');
        session()->remove('suites');
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        if ($request->search === 'venda') {
            session()->put('venda', true);
            session()->remove('locacao');
            $imoveis = $this->createQuery('categoria');
        }

        if ($request->search === 'locacao') {
            session()->put('locacao', true);
            session()->remove('venda');
            $imoveis = $this->createQuery('categoria');
        }

        if($imoveis->count()){
            foreach($imoveis as $categoriaImovel){
                $categoria[] = $categoriaImovel->categoria;
            }

            $collect = collect($categoria);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function categoria(Request $request)
    {
        session()->remove('tipo');
        session()->remove('bairro');
        session()->remove('dormitorios');
        session()->remove('suites');
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('categoria', $request->search);
        $tipoImoveis = $this->createQuery('tipo');

        if($tipoImoveis->count()){
            foreach($tipoImoveis as $imovel){
                $tipo[] = $imovel->tipo;
            }

            $collect = collect($tipo);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function tipo(Request $request)
    {
        session()->remove('bairro');
        session()->remove('dormitorios');
        session()->remove('suites');
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('tipo', $request->search);
        $bairroImoveis = $this->createQuery('bairro');

        if($bairroImoveis->count()){
            foreach($bairroImoveis as $imovel){
                $bairro[] = $imovel->bairro;
            }

            $collect = collect($bairro);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function bairro(Request $request)
    {
        session()->remove('dormitorios');
        session()->remove('suites');
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('bairro', $request->search);
        $dormitoriosImoveis = $this->createQuery('dormitorios');

        if($dormitoriosImoveis->count()){
            foreach($dormitoriosImoveis as $imovel){
                if($imovel->dormitorios === 0 || $imovel->dormitorios === 1) {
                    $dormitorios[] = $imovel->dormitorios . ' dormitório';
                } else {
                    $dormitorios[] = $imovel->dormitorios . ' dormitórios';
                }
            }

            $dormitorios[] = 'Indiferente';

            $collect = collect($dormitorios)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function dormitorios(Request $request)
    {
        session()->remove('suites');
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('dormitorios', $request->search);
        $suitesImoveis = $this->createQuery('suites');

        if($suitesImoveis->count()){
            foreach($suitesImoveis as $imovel){
                if($imovel->suites === 1){
                    $suites[] = $imovel->suites . ' suíte';
                } elseif($imovel->suites > 1) {
                    $suites[] = $imovel->suites . ' suítes';
                } elseif($imovel->suites === 0 || $imovel->suites === ''){
                    $suites[] = 'Nada encontrado!';
                }
            }

            $suites[] = 'Indiferente';

            $collect = collect($suites)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function suites(Request $request)
    {
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('suites', $request->search);
        $banheirosImoveis = $this->createQuery('banheiros');

        if($banheirosImoveis->count()){
            foreach($banheirosImoveis as $imovel){
                if($imovel->banheiros === 0 || $imovel->banheiros === 1){
                    $banheiros[] = $imovel->banheiros . ' banheiro';
                } else {
                    $banheiros[] = $imovel->banheiros . ' banheiros';
                }
            }

            $banheiros[] = 'Indiferente';

            $collect = collect($banheiros)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function banheiros(Request $request)
    {
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('banheiros', $request->search);

        $garagemImoveis = $this->createQuery('garagem,garagem_coberta');

        if($garagemImoveis->count()){
            foreach($garagemImoveis as $imovel){
                $imovel->garagem = $imovel->garagem + $imovel->garagem_coberta;

                if($imovel->garagem === 0 || $imovel->garagem === 1){
                    $garagem[] = $imovel->garagem . ' garagem';
                } else {
                    $garagem[] = $imovel->garagem . ' garagens';
                }
            }

            $garagem[] = 'Indiferente';

            $collect = collect($garagem)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function garagem(Request $request)
    {
        session()->remove('price_base');
        session()->remove('price_limit');

        session()->put('garagem', $request->search);

        if(session('venda') === true) {
            $priceBaseProperties = $this->createQuery('valor_venda as valor');
        } else {
            $priceBaseProperties = $this->createQuery('valor_locacao as valor');
        }

        if($priceBaseProperties->count()){
            foreach($priceBaseProperties as $imovel){
                $valor[] = 'À partir de R$ ' . number_format($imovel->valor, 2, ',', '.');
            }

            $collect = collect($valor)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function priceBase(Request $request)
    {
        session()->remove('price_limit');

        session()->put('price_base', $request->search);

        if(session('venda') === true) {
            $priceLimitProperties = $this->createQuery('valor_venda as valor');
        } else {
            $priceLimitProperties = $this->createQuery('valor_locacao as valor');
        }

        if($priceLimitProperties->count()){
            foreach($priceLimitProperties as $imovel){
                $valor[] = 'Até R$ ' . number_format($imovel->valor, 2, ',', '.');
            }

            $collect = collect($valor)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function priceLimit(Request $request)
    {
        session()->put('price_limit', $request->search);
        return response()->json($this->setResponse('success', []));
    }

    private function setResponse(string $status, array $data = null, string $message = null)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }

    public function clearAllData()
    {
        session()->remove('venda');
        session()->remove('locacao');
        session()->remove('categoria');
        session()->remove('tipo');
        session()->remove('bairro');
        session()->remove('dormitorios');
        session()->remove('suites');
        session()->remove('banheiros');
        session()->remove('garagem');
        session()->remove('price_base');
        session()->remove('price_limit');
    }

    public function createQuery($field)
    {
        $venda = session('venda');
        $locacao = session('locacao');
        $categoria = session('categoria');
        $tipo = session('tipo');
        $bairro = session('bairro');
        $dormitorios = session('dormitorios');
        $suites = session('suites');
        $banheiros = session('banheiros');
        $garagem = session('garagem');
        $priceBase = session('price_base');
        $priceLimit = session('price_limit');

        return DB::table('imoveis')
            ->where('tenant_id', '=', $this->tenant->id)
            ->where('status', '=', '1')
            ->when($venda, function($query, $venda){
                return $query->where('venda', $venda);
            })
            ->when($locacao, function($query, $locacao){
                return $query->where('locacao', $locacao);
            })
            ->when($categoria, function($query, $categoria){
                return $query->where('categoria', $categoria);
            })
            ->when($tipo, function($query, $tipo){
                return $query->whereIn('tipo', $tipo);
            })
            ->when($bairro, function($query, $bairro){
                return $query->whereIn('bairro', $bairro);
            })
            ->when($dormitorios, function($query, $dormitorios){

                if($dormitorios == 'Indiferente'){
                    return $query;
                }
                $dormitorios = (int) $dormitorios;
                return $query->where('dormitorios', $dormitorios);
            })
            ->when($suites, function($query, $suites){

                if($suites == 'Indiferente'){
                    return $query;
                }
                $suites = (int) $suites;
                return $query->where('suites', $suites);
            })
            ->when($banheiros, function($query, $banheiros){

                if($banheiros == 'Indiferente'){
                    return $query;
                }
                $banheiros = (int) $banheiros;
                return $query->where('banheiros', $banheiros);
            })
            ->when($garagem, function($query, $garagem){

                if($garagem == 'Indiferente'){
                    return $query;
                }
                $garagem = (int) $garagem;
                return $query->whereRaw('(garagem + garagem_coberta = ? OR garagem = ? OR garagem_coberta = ?)', [$garagem, $garagem, $garagem]);
            })
            ->when($priceBase, function($query, $priceBase){

                if($priceBase == 'Indiferente'){
                    return $query;
                }
                $priceBase = (float) str_replace(',', '.', str_replace('.', '', explode('R$ ', $priceBase, 2)[1]));
                if(session('venda') == true){
                    return $query->where('valor_venda', '>=', $priceBase);
                } else {
                    return $query->where('valor_locacao', '>=', $priceBase);
                }
            })
            ->when($priceLimit, function($query, $priceLimit){

                if($priceLimit == 'Indiferente'){
                    return $query;
                }
                $priceLimit = (float) str_replace(',', '.', str_replace('.', '', explode('R$ ', $priceLimit, 2)[1]));
                if(session('venda') == true){
                    return $query->where('valor_venda', '<=', $priceLimit);
                } else {
                    return $query->where('valor_locacao', '<=', $priceLimit);
                }
            })
            ->get(explode(',', $field));
    }
    

    public function experienceCategory(Request $request)
    {
        $this->clearAllData();

        if ($request->slug == 'cobertura') {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->where('experience', 'Cobertura')->available()->paginate(18);
            $title = 'Viva a experiência de morar na Cobertura';
            $tagline = 'Viva a experiência de morar na Cobertura...';
        } elseif ($request->slug == 'alto-padrao') {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->where('experience', 'Alto Padrão')->available()->paginate(18);
            $title = 'Viva a experiência de morar em um imóvel de alto padrão';
            $tagline = 'Viva a experiência de morar em um imóvel de alto padrão...';
        } elseif ($request->slug == 'de-frente-para-o-mar') {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->where('experience', 'De Frente para o Mar')->available()->paginate(15);
            $title = 'Viva a experiência de morar em um imóvel de frente para o mar';
            $tagline = 'Viva a experiência de morar em um imóvel de frente para o mar...';
        } elseif ($request->slug == 'condominio-fechado') {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->where('experience', 'Condomínio Fechado')->available()->paginate(15);
            $title = 'Viva a experiência de morar em Condomínio Fechado';
            $tagline = 'Viva a experiência de morar em Condomínio Fechado...';
        } elseif ($request->slug == 'compacto') {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->where('experience', 'Compacto')->available()->paginate(15);
            $title = 'Viva a experiência de morar em um Compacto';
            $tagline = 'Viva a experiência de morar em um Compacto...';
        } elseif ($request->slug == 'lojas-e-salas') {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->where('experience', 'Lojas e Salas')->available()->paginate(15);
            $title = 'Encontre aqui Lojas e Salas';
            $tagline = 'Encontre aqui Lojas e Salas...';
        } else {
            $imoveis = Imovel::orderBy('created_at', 'DESC')->whereNotNull('experience')->available()->paginate(15);
            $title = 'Encontre um imóvel com a experiência que você quer viver!';
            $tagline = 'Encontre um imóvel com a experiência que você quer viver!';
        }

        $head = $this->seo->render($title ?? 'Super Imóveis Sistema Imobiliário',
            $tagline,
            route('web.experienceCategory', ['slug' => $request->slug]),
            $this->tenant->getMetaImg() ?? 'https://superimoveis.info/media/metaimg.jpg'
        );

        if(empty($request->slug)){
            return view('web.sites.'.$this->tenant->template.'.404',[
                'head' => $head,
                'tenant' => $this->tenant
            ]);
        }

        return view('web.sites.'.$this->tenant->template.'.imoveis.filtro', [
            'tenant' => $this->tenant,
            'head' => $head,
            'imoveis' => $imoveis,
        ]);
    }
}
