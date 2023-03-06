@include('layouts.include_page_header')
@include('layouts.include_sidebar')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
  
    <section class="section dashboard">
        <div class="row">
            
        </div>
    </section>
</main>

@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
</script>
@endpush

@include('layouts.include_page_footer')
@include('layouts.include_js')