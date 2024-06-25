<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\Atendimento;
use App\Mail\AtendimentoRetorno;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SendEmailController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->config = Config::where('id', 1)->first();
    }

    public function contact()
    {
        return view('web.'.$this->config->template.'.contact');
    }

    public function sendEmail(Request $request)
    {
        if($request->nome == ''){
            $json = "Por favor preencha o campo";
            return response()->json(['errorName' => $json], 422);
        }

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo email está vazio ou não tem um formato válido!";
            return response()->json(['errorEmail' => $json], 422);
        }

        if($request->assunto == ''){
            $json = "Por favor preencha o Assunto!";
            return response()->json(['errorAssunto' => $json], 422);
        }

        if($request->mensagem == ''){
            $json = "Por favor preencha sua Mensagem";
            return response()->json(['errorMensagem' => $json], 422);
        }else{
            $data = [
                'sitename' => $this->config->app_name,
                'siteemail' => env('MAIL_FROM_ADDRESS'),
                'clisiteemail' => $this->config->email,
                'reply_name' => $request->nome,
                'reply_email' => $request->email,
                'telefone' => $request->telefone,
                'assunto' => $request->assunto ?? '#Atendimento pelo Site',
                'mensagem' => $request->mensagem
            ];

            $retorno = [
                'sitename' => $this->config->app_name,
                'siteemail' => env('MAIL_FROM_ADDRESS'),
                'reply_name' => $request->nome,
                'reply_email' => $request->email
            ];
            
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new Atendimento($data));
            Mail::to($request->email)->send(new AtendimentoRetorno($retorno));
            
            $json = "Obrigado $request->nome sua mensagem foi enviada com sucesso!"; 
            return response()->json(['sucess' => $json], 200);
        }
    }
}
