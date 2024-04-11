<div class="invoice-content">
    <div style="line-height: 0.5">
    </div>
    <table class="result ">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Paciente</th>
                <th>Medico</th>
                <th>Empresa</th>
                <th>Monto</th>
                <th>Anticipo</th>
                <th>Adeudo</th>
                <th>Descuento</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $descuentos = 0;
                $solicitudes = 0;
            @endphp
            @foreach ($folios as $key=> $folio)
                <tr>
                    <td>{{$folio->folio}}</td>
                    <td><p>
                        {{$folio->paciente()->first()->nombre}}
                        </p>
                    </td>
                    <td>
                        <p>
                            {{$folio->doctores()->first()->nombre}}
                        </p>
                    </td>
                    <td>
                        <p>
                            {{$folio->empresas()->first()->descripcion}}
                        </p>
                    </td>
                    {{-- Monto --}}
                    <td>
                        $ {{$folio->lista()->sum('precio')}}
                        @php
                            $total += $folio->lista()->sum('precio');
                        @endphp
                    </td>
                    {{-- Anticipo --}}
                    <td>
                        @php
                            if($folio->pago()->count() === 1){
                                echo '$ ' . $folio->pago()->first()->importe;
                            }else{
                                // echo '$ ' .  $folio->pago()->first()->importe;
                                echo '$ 0 ';
                            }

                            
                        @endphp
                    </td>
                    {{-- Adeudos --}}
                    <td>
                        @php
                            if($folio->estado == 'pagado'){
                                // echo $suma - $folio->pago()->first()->importe;

                                echo '$ 0';
                            }else{
                                // echo $folio->pago()->first()->importe;
                                if($folio->pago()->first() == null){
                                    echo '$ 0';
                                }else {
                                    # code...
                                    echo "$ " . (($folio->lista()->sum('precio') - $folio->pago()->first()->importe) - $folio->descuento);
                                }
                            }
                        @endphp
                    </td>
                    {{-- <td>{{(isset($folio->pago()->first()->tipo_movimiento)) ? $folio->pago()->first()->tipo_movimiento : 'undefined'}}</td> --}}
                    <td>$ {{ $folio->descuento}}</td>
                    @php
                        $descuentos += $folio->descuento;
                    @endphp
                    {{-- <td>{{$folio->estado}}</td> --}}
                    <td>{{$folio->created_at}}</td>
                </tr>
                <tr>
                    <td  colspan="9">
                        <strong>Estudios: </strong>
                        @forelse ($folio->lista()->get() as $estudio)
                            <span>{{$estudio->clave}} </span>
                        @empty
                        @endforelse
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>
        <strong>Total: </strong> $ {{$total}} <br>
        <strong>Descuentos: </strong> $ {{$descuentos}} <br>
        <strong>Total real: </strong> $ {{$total - $descuentos}} <br>
        <strong>Solicitudes: </strong> {{$folios->count()}}
    </p>

    {{-- Segunda página --}}
    {{-- <p class="break"></p> --}}

</div>