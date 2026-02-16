@extends('admin.layout')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
@endsection
@section('title')
    {{ $form->name }} adlı formun cevap listesi
@endsection
@section('content-title')
    <div class="col">
        <h2 class="page-title">
            {{ $form->name }} adlı formun cevap listesi
        </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="dropdown">
            <button class="btn btn-primart dropdown-toggle" type="button" id="" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ $form->language->text }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                @foreach ($brothers as $b)
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.form.show', $b->id) }}">{{ $b->language->text }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header justify-content-end">
            <a href="{{ route('admin.form.export-excel', $form->id) }}" class="btn btn-warning">Excel Çıkar</a>
        </div>
        <div class="card-body">
            @if (count($form->answers) > 0)
                <div class="accordion" id="accordion-example">
                    @foreach ($form->answers as $key => $item)
                        @php
                            $values = json_decode($item->answer, true);
                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{ $key }}">
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <a href="{{ route('admin.form-answer.check', $item->id) }}">
                                            @if ($item->checked)
                                                <i class="fa fa-check-circle-o fa-2x text-success"></i>
                                            @else
                                                <i class="fa fa-circle-o fa-2x text-primary"></i>
                                            @endif
                                        </a>
                                    </div>
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $key }}" aria-expanded="false">
                                        {{ Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i') }}
                                    </button>
                                    <a onclick="return confirm('Silmek istediğinize emin misiniz?')"
                                        href="{{ route('admin.form-answer.destroy', $item->id) }}"
                                        class="btn btn-danger me-2">Sil</a>
                                </div>
                            </h2>
                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordion-example" style="">
                                <div class="accordion-body pt-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            @foreach ($values as $value)
                                                @php
                                                    $ignoredListTypes = ['button|reset', 'button|submit'];
                                                    $type = $value['type'];
                                                    $question = $value['question'];
                                                @endphp
                                                @if (!in_array($type, $ignoredListTypes))
                                                    <tr>
                                                        <td>{{ $question }}</td>
                                                        <td>
                                                            @if ($type == 'input|checkbox')
                                                                @if ($value['answer'] != '')
                                                                    @foreach (json_decode($value['answer'], true) as $c)
                                                                        {{ $c }} |
                                                                    @endforeach
                                                                @else
                                                                    <b>Kayıt Yok</b>
                                                                @endif
                                                            @elseif($type == 'input|file')
                                                                @if ($value['answer'] != '')
                                                                    <a href="{{ $value['answer'] }}"
                                                                        class="btn btn-primary" target="_blank">Göster</a>
                                                                @else
                                                                    <b>Kayıt Yok</b>
                                                                @endif
                                                            @elseif($type == 'input|date')
                                                                {{ Carbon\Carbon::parse($value['answer'])->format('d.m.Y') }}
                                                            @elseif($type == 'input|datetime')
                                                                {{ Carbon\Carbon::parse($value['answer'])->format('d.m.Y H:i') }}
                                                            @else
                                                                {{ $value['answer'] }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h4 class="text-center">Kayıt bulunamadı</h4>
            @endif
        </div>
    </div>
@endsection
