@php
    $imageExts = ['png', 'jpg', 'jpeg', 'jfif', 'webp'];
    $svgicon = '
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file w-100 h-50" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
            </svg>';
@endphp
@foreach ($fields as $field)
    @php
        $attributes = '';
        $values = explode(',', $field->values);
        $attr = explode(',', $field->attr);
        foreach ($attr as $att) {
            $attributes .= $att . ' ';
        }
        $inputParams = explode('|', $field->type);

    @endphp
    <div class="col-12">
        <div class="form-group">
            <label for="{{ $field->key }}" class="form-label">{{ $field->name }}</label>
            @if ($inputParams[0] == 'input')
                @if ($inputParams[1] == 'text')
                    <input type="text" class="form-control"
                        value="{{ isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : '' }}"
                        id="{{ $field->key }}" name="fields[{{ $field->key }}]" {{ $attributes }}>
                @elseif($inputParams[1] == 'number')
                    <input type="number" class="form-control"
                        value="{{ isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : '' }}"
                        id="{{ $field->key }}" name="fields[{{ $field->key }}]" {{ $attributes }}>
                @elseif($inputParams[1] == 'email')
                    <input type="email" class="form-control"
                        value="{{ isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : '' }}"
                        id="{{ $field->key }}" name="fields[{{ $field->key }}]" {{ $attributes }}>
                @elseif($inputParams[1] == 'password')
                    <input type="password" class="form-control"
                        value="{{ isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : '' }}"
                        id="{{ $field->key }}" name="fields[{{ $field->key }}]" {{ $attributes }}>
                @elseif($inputParams[1] == 'url')
                    <input type="url" class="form-control"
                        value="{{ isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? $FieldValues['fields'][$field->key] : '') : '' }}"
                        id="{{ $field->key }}" name="fields[{{ $field->key }}]" {{ $attributes }}>
                @elseif($inputParams[1] == 'date')
                    <input type="date" class="form-control"
                        value="{{ isset($FieldValues) ? (isset($FieldValues['fields'][$field->key]) ? Carbon\Carbon::parse($FieldValues['fields'][$field->key])->format('Y-m-d') : '') : '' }}"
                        id="{{ $field->key }}" name="fields[{{ $field->key }}]" {{ $attributes }}>
                @elseif($inputParams[1] == 'checkbox')
                    <div class="d-flex gap-4">
                        @foreach ($values as $key => $value)
                            @php
                                $checked = '';
                                if (isset($FieldValues) && isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] == $value) {
                                    $checked = 'checked';
                                }
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fields[{{ $field->key }}]"
                                    value="{{ $value }}" {{ $checked }}
                                    id="{{ $value }}-{{ $key }}" {{ $attributes }}>
                                <label class="form-check-label" for="{{ $value }}-{{ $key }}">
                                    {{ $value }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @elseif($inputParams[1] == 'radio')
                    <div class="d-flex gap-4">
                        @foreach ($values as $key => $value)
                            @php
                                $checked = '';
                                if (isset($FieldValues) && isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] == $value) {
                                    $checked = 'checked';
                                }
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" {{ $checked }} type="radio"
                                    name="fields[{{ $field->key }}]" value="{{ $value }}"
                                    id="{{ $value }}-{{ $key }}" {{ $attributes }}>
                                <label class="form-check-label" for="{{ $value }}-{{ $key }}">
                                    {{ $value }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @elseif($inputParams[1] == 'file' && $inputParams[2] == 'single')
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-none" id="file-hidden-inputs-{{ $field->key }}">
                            @if (isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null)
                                @foreach ($FieldValues['fields'][$field->key] as $image)
                                    <input name="fields[{{ $field->key }}][{{ $image['language']['key'] }}][]"
                                        value="{{ $image['id'] }}" id="hidden-file-input-{{ $image['id'] }}" />
                                @endforeach
                            @endif
                        </div>
                        <div class="file-container align-items-stretch row row-cols-auto gap-3"
                            id="file-selector-{{ $field->key }}">
                            @if (isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null)
                                @foreach ($FieldValues['fields'][$field->key] as $image)
                                    <div class="d-flex flex-column align-items-center border p-2"
                                        id="file-dom-selector-{{ $image['id'] }}" data-id="{{ $image['id'] }}">
                                        <div class="h-100 d-flex align-items-center">
                                            @if (in_array($image['extension'], $imageExts))
                                                <img class="img-fluid" width="85" src="{{ $image['path'] }}" />
                                            @else
                                                {!! $svgicon !!}
                                            @endif
                                        </div>
                                        <p>{{ $image['original_name'] }}</p>
                                        <div class="">
                                            <a href="#" class="btn btn-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-arrows-move m-0" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M18 9l3 3l-3 3"></path>
                                                    <path d="M15 12h6"></path>
                                                    <path d="M6 9l-3 3l3 3"></path>
                                                    <path d="M3 12h6"></path>
                                                    <path d="M9 18l3 3l3 -3"></path>
                                                    <path d="M12 15v6"></path>
                                                    <path d="M15 6l-3 -3l-3 3"></path>
                                                    <path d="M12 3v6"></path>
                                                </svg>
                                            </a>
                                            <button type="button" data-field-type="single"
                                                data-field-name="{{ $field->key }}"
                                                data-selector="{{ $image['id'] }}" class="btn btn-danger remove-file">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash m-0" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @php
                            $disabled = '';
                            if (isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != '' && count($FieldValues['fields'][$field->key]) > 0) {
                                $disabled = 'disabled';
                            }
                        @endphp
                        <a href="#" id="showDropzoneButton-{{ $field->key }}"
                            class="btn btn-primary {{ $disabled }}" data-bs-toggle="modal"
                            data-bs-target="#uploadFileModal-{{ $field->key }}">
                            <svg style="margin:0 !important;" xmlns="http://www.w3.org/2000/svg" class="icon"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                        </a>
                    </div>
                @elseif($inputParams[1] == 'file' && $inputParams[2] == 'multiple')
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-none" id="file-hidden-inputs-{{ $field->key }}">
                            @if (isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null)
                                @foreach ($FieldValues['fields'][$field->key] as $image)
                                    <input name="fields[{{ $field->key }}][{{ $image['language']['key'] }}][]"
                                        value="{{ $image['id'] }}" id="hidden-file-input-{{ $image['id'] }}" />
                                @endforeach
                            @endif
                        </div>
                        <div class="file-container  align-items-stretch row row-cols-auto gap-3"
                            id="file-selector-{{ $field->key }}">
                            @if (isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] != null)
                                @foreach ($FieldValues['fields'][$field->key] as $image)
                                    <div class="d-flex flex-column align-items-center border p-2"
                                        id="file-dom-selector-{{ $image['id'] }}" data-id="{{ $image['id'] }}">
                                        <div class="h-100 d-flex align-items-center">
                                            @if (in_array($image['extension'], $imageExts))
                                                <img class="img-fluid" width="85" src="{{ $image['path'] }}" />
                                            @else
                                                {!! $svgicon !!}
                                            @endif
                                        </div>
                                        <p>{{ $image['original_name'] }}</p>
                                        <div class="">
                                            <a href="#" class="btn btn-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-arrows-move m-0"
                                                    width="24" height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M18 9l3 3l-3 3"></path>
                                                    <path d="M15 12h6"></path>
                                                    <path d="M6 9l-3 3l3 3"></path>
                                                    <path d="M3 12h6"></path>
                                                    <path d="M9 18l3 3l3 -3"></path>
                                                    <path d="M12 15v6"></path>
                                                    <path d="M15 6l-3 -3l-3 3"></path>
                                                    <path d="M12 3v6"></path>
                                                </svg>
                                            </a>
                                            <button type="button" data-selector="{{ $image['id'] }}"
                                                class="btn btn-danger remove-file">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash m-0" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#uploadFileModal-{{ $field->key }}">
                            <svg style="margin:0 !important;" xmlns="http://www.w3.org/2000/svg" class="icon"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                        </a>
                    </div>
                @endif
            @endif
            @if ($inputParams[0] == 'textarea')
                @php
                    $textAreaValue = '';
                    if (isset($FieldValues) && isset($FieldValues['fields'][$field->key])) {
                        $textAreaValue = $FieldValues['fields'][$field->key];
                    }
                @endphp
                @if ($inputParams[1] == 'textarea')
                    <textarea name="fields[{{ $field->key }}]" id="{{ $field->key }}" {{ $attributes }} class="form-control">{!! $textAreaValue !!}</textarea>
                @elseif ($inputParams[1] == 'editor')
                    <textarea name="fields[{{ $field->key }}]" id="tinymce-{{ $field->key }}" name="fields[{{ $field->key }}]"
                        {{ $attributes }}>{!! $textAreaValue !!}</textarea>
                @endif
            @endif
            @if ($inputParams[0] == 'select')
                <select name="fields[{{ $field->key }}]" id="{{ $field->key }}" {{ $attributes }}
                    class="form-select">
                    @foreach ($values as $v)
                        @php
                            $selected = '';
                            if (isset($FieldValues) && isset($FieldValues['fields'][$field->key]) && $FieldValues['fields'][$field->key] == $v) {
                                $selected = 'selected';
                            }
                        @endphp
                        <option value="{{ $v }}" {{ $selected }}>{{ $v }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
@endforeach
