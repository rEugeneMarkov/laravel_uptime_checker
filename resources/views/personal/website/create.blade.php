@extends('layouts.personal')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('personal.website.store') }}" method="POST">
                    @csrf
                    <div class="form-group w-50">
                        <label class="mb-3 mt-2">Site title</label>
                        <input type="text" class="form-control" name="title" placeholder="Site title"
                            value="{{ old('title') }}">
                        @error('title')
                            <div class="text-danger">Is required</div>
                        @enderror

                        <div class="mb-3 mt-2">
                            <label for="basic-url" class="form-label">Website</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">https://</span>
                                <input type="text" class="form-control" name="website" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ old('website') }}">
                            </div>
                        </div>
                        @error('website')
                            <div class="text-danger">Is required</div>
                        @enderror

                        <label class="mb-3 mt-2">E-mail for notification</label>
                        <input type="email" class="form-control" name="email" placeholder="E-mail for notification"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">Is required</div>
                        @enderror

                        {{-- <label class="mb-3 mt-2">Check interval</label>
                        <input type="text" class="form-control" name="interval" placeholder="E-mail for notification"
                            value="{{ old('interval') }}">
                        @error('interval')
                            <div class="text-danger">Is required</div>
                        @enderror --}}

                        <div class="form-group mt-2">
                            <label>Check frequency</label>
                            <select name="frequency_id"class="form-control">

                                @foreach ($frequencies as $frequency)
                                    <option value="{{ $frequency->id }}"
                                        {{ $frequency->id == old('frequency_id') ? 'selected' : '' }}>
                                        {{ $frequency->title }}</option>
                                @endforeach

                            </select>
                        </div>


                    </div>
                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-primary" value="Add website">
                    </div>
                </form>
            </div>
            <!-- ./col -->
        </div>
    </div>
@endsection
