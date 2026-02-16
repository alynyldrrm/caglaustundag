@if ($questions)
    @foreach ($questions as $key => $question)
        @php
            $name = $question['name'];
            $attributes = '';
            $values = explode(',', $question['values']);
            $attr = explode(',', $question['attr']);
            foreach ($attr as $att) {
                $attributes .= $att . ' ';
            }
            $inputParams = explode('|', $question['field']);
            $notLabels = ['button|reset', 'button|submit'];
        @endphp

        <div class="col-12 col-lg-6">
            <div class="form-group">
                @if (!in_array($question['field'], $notLabels))
                    <label for="{{ $name }}">{{ $name }}</label>
                @endif
                @if ($inputParams[0] == 'input')
                    @if ($inputParams[1] == 'text')
                        <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'number')
                        <input type="number" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'email')
                        <input type="email" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'password')
                        <input type="password" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'url')
                        <input type="url" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'date')
                        <input type="date" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'datetime')
                        <input type="datetime-local" name="{{ $name }}" id="{{ $name }}"
                            class="form-control" {!! $attributes !!}>
                    @elseif ($inputParams[1] == 'checkbox')
                        <div class="d-flex gap-4">
                            @foreach ($values as $key => $value)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{ $name }}[]"
                                        value="{{ $value }}" id="{{ $value }}" {!! $attributes !!}>
                                    <label class="form-check-label" for="{{ $value }}">
                                        {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($inputParams[1] == 'radio')
                        <div class="d-flex gap-4">
                            @foreach ($values as $key => $value)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ $name }}"
                                        value="{{ $value }}" id="{{ $value }}" {!! $attributes !!}>
                                    <label class="form-check-label" for="{{ $value }}">
                                        {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($inputParams[1] == 'file')
                        <input type="file" name="{{ $name }}" id="{{ $name }}" class="form-control"
                            {!! $attributes !!}>
                    @endif
                @elseif($inputParams[0] == 'textarea')
                    <textarea name="{{ $name }}" id="{{ $name }}" class="form-control" {!! $attributes !!}></textarea>
                @elseif($inputParams[0] == 'select')
                    <select name="{{ $name }}" id="{{ $name }}" class="form-select">
                        @foreach ($values as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                @elseif($inputParams[0] == 'button')
                    @if ($inputParams[1] == 'reset')
                        <button class="btn" type="reset" {!! $attributes !!}>
                            {{ $name }}
                        </button>
                    @elseif($inputParams[1] == 'submit')
                        <button class="btn btn-primary" type="submit" {!! $attributes !!}>
                            {{ $name }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@endif
