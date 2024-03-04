@extends('layouts.errors')

@section('content')
  
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Ops! página não encontrada.</h3>

          <p>
            Não foi possível encontrar a página que você procurava.
            Enquanto isso, você pode <a href="/">retornar para dashboard</a> 
          </p>
        </div>
      </div>
    </section>
@endsection
