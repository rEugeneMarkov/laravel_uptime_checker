@extends('layouts.personal')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="border rounded col-lg-6">
            <div class=" col-12 d-flex justify-content-center">
                <form action="{{ route('personal.website.update', $website->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="mt-3">Friendly Name</label>
                        <input type="text" class="form-control" name="title" placeholder="Site title"
                            value="{{ $website->title }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="mt-3">
                            <label for="basic-url" class="form-label">URL (or IP)</label>
                            <div class="input-group">
                                <span class="input-group-text">http(s)://</span>
                                <input type="text" class="form-control" name="website" value="{{ $website->website }}">
                            </div>
                        </div>
                        @error('website')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label class="mt-3">E-mail for notification</label>
                        <input type="email" class="form-control" name="email" placeholder="E-mail for notification"
                            value="{{ $website->email }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mt-3">Monitoring Interval</label>
                                <input type="text" class="form-control" name="interval" placeholder="Interval"
                                    value="{{ $website->interval }}">
                                <div class="w-25">minute(s).</div>
                                @error('interval')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="mt-3">Monitoring Timeout</label>
                                <input type="text" class="form-control" name="timeout" placeholder="Timeout"
                                    value="{{ $website->timeout }}">
                                <div class="w-25">second(s).</div>
                                @error('timeout')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
