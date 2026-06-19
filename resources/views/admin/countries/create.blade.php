@extends('admin.layouts.admin_dashboard', ['title' => $model])

@section('content')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb', ['model' => $model])
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add New Country</h3>
                                <a href="{{ route('admin.countries.index') }}" class="btn btn-sm btn-secondary float-right">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>

                            <form method="POST" action="{{ route('admin.countries.store') }}">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="code">Country Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ old('code') }}"
                                            placeholder="e.g., US, EG, UK" maxlength="2"
                                            style="text-transform: uppercase;">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Two-letter country code (ISO 3166-1
                                            alpha-2)</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="flag_icon">Flag Icon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i id="flag-preview" class="flag-icon flag-icon-us"></i>
                                                </span>
                                            </div>
                                            <select class="form-control @error('flag_icon') is-invalid @enderror"
                                                id="flag_icon" name="flag_icon">
                                                <option value="">Select a flag icon</option>
                                                <option value="flag-icon-ad"
                                                    {{ old('flag_icon') == 'flag-icon-ad' ? 'selected' : '' }}>🇦🇩 Andorra
                                                </option>
                                                <option value="flag-icon-ae"
                                                    {{ old('flag_icon') == 'flag-icon-ae' ? 'selected' : '' }}>🇦🇪 United
                                                    Arab Emirates</option>
                                                <option value="flag-icon-af"
                                                    {{ old('flag_icon') == 'flag-icon-af' ? 'selected' : '' }}>🇦🇫
                                                    Afghanistan</option>
                                                <option value="flag-icon-ag"
                                                    {{ old('flag_icon') == 'flag-icon-ag' ? 'selected' : '' }}>🇦🇬 Antigua
                                                    and Barbuda</option>
                                                <option value="flag-icon-ai"
                                                    {{ old('flag_icon') == 'flag-icon-ai' ? 'selected' : '' }}>🇦🇮 Anguilla
                                                </option>
                                                <option value="flag-icon-al"
                                                    {{ old('flag_icon') == 'flag-icon-al' ? 'selected' : '' }}>🇦🇱 Albania
                                                </option>
                                                <option value="flag-icon-am"
                                                    {{ old('flag_icon') == 'flag-icon-am' ? 'selected' : '' }}>🇦🇲 Armenia
                                                </option>
                                                <option value="flag-icon-ao"
                                                    {{ old('flag_icon') == 'flag-icon-ao' ? 'selected' : '' }}>🇦🇴 Angola
                                                </option>
                                                <option value="flag-icon-aq"
                                                    {{ old('flag_icon') == 'flag-icon-aq' ? 'selected' : '' }}>🇦🇶
                                                    Antarctica</option>
                                                <option value="flag-icon-ar"
                                                    {{ old('flag_icon') == 'flag-icon-ar' ? 'selected' : '' }}>🇦🇷
                                                    Argentina</option>
                                                <option value="flag-icon-as"
                                                    {{ old('flag_icon') == 'flag-icon-as' ? 'selected' : '' }}>🇦🇸
                                                    American Samoa</option>
                                                <option value="flag-icon-at"
                                                    {{ old('flag_icon') == 'flag-icon-at' ? 'selected' : '' }}>🇦🇹 Austria
                                                </option>
                                                <option value="flag-icon-au"
                                                    {{ old('flag_icon') == 'flag-icon-au' ? 'selected' : '' }}>🇦🇺
                                                    Australia</option>
                                                <option value="flag-icon-aw"
                                                    {{ old('flag_icon') == 'flag-icon-aw' ? 'selected' : '' }}>🇦🇼 Aruba
                                                </option>
                                                <option value="flag-icon-ax"
                                                    {{ old('flag_icon') == 'flag-icon-ax' ? 'selected' : '' }}>🇦🇽 Åland
                                                    Islands</option>
                                                <option value="flag-icon-az"
                                                    {{ old('flag_icon') == 'flag-icon-az' ? 'selected' : '' }}>🇦🇿
                                                    Azerbaijan</option>
                                                <option value="flag-icon-ba"
                                                    {{ old('flag_icon') == 'flag-icon-ba' ? 'selected' : '' }}>🇧🇦 Bosnia
                                                    and Herzegovina</option>
                                                <option value="flag-icon-bb"
                                                    {{ old('flag_icon') == 'flag-icon-bb' ? 'selected' : '' }}>🇧🇧
                                                    Barbados</option>
                                                <option value="flag-icon-bd"
                                                    {{ old('flag_icon') == 'flag-icon-bd' ? 'selected' : '' }}>🇧🇩
                                                    Bangladesh</option>
                                                <option value="flag-icon-be"
                                                    {{ old('flag_icon') == 'flag-icon-be' ? 'selected' : '' }}>🇧🇪 Belgium
                                                </option>
                                                <option value="flag-icon-bf"
                                                    {{ old('flag_icon') == 'flag-icon-bf' ? 'selected' : '' }}>🇧🇫 Burkina
                                                    Faso</option>
                                                <option value="flag-icon-bg"
                                                    {{ old('flag_icon') == 'flag-icon-bg' ? 'selected' : '' }}>🇧🇬
                                                    Bulgaria</option>
                                                <option value="flag-icon-bh"
                                                    {{ old('flag_icon') == 'flag-icon-bh' ? 'selected' : '' }}>🇧🇭 Bahrain
                                                </option>
                                                <option value="flag-icon-bi"
                                                    {{ old('flag_icon') == 'flag-icon-bi' ? 'selected' : '' }}>🇧🇮 Burundi
                                                </option>
                                                <option value="flag-icon-bj"
                                                    {{ old('flag_icon') == 'flag-icon-bj' ? 'selected' : '' }}>🇧🇯 Benin
                                                </option>
                                                <option value="flag-icon-bl"
                                                    {{ old('flag_icon') == 'flag-icon-bl' ? 'selected' : '' }}>🇧🇱 Saint
                                                    Barthélemy</option>
                                                <option value="flag-icon-bm"
                                                    {{ old('flag_icon') == 'flag-icon-bm' ? 'selected' : '' }}>🇧🇲 Bermuda
                                                </option>
                                                <option value="flag-icon-bn"
                                                    {{ old('flag_icon') == 'flag-icon-bn' ? 'selected' : '' }}>🇧🇳 Brunei
                                                </option>
                                                <option value="flag-icon-bo"
                                                    {{ old('flag_icon') == 'flag-icon-bo' ? 'selected' : '' }}>🇧🇴 Bolivia
                                                </option>
                                                <option value="flag-icon-bq"
                                                    {{ old('flag_icon') == 'flag-icon-bq' ? 'selected' : '' }}>🇧🇶
                                                    Caribbean Netherlands</option>
                                                <option value="flag-icon-br"
                                                    {{ old('flag_icon') == 'flag-icon-br' ? 'selected' : '' }}>🇧🇷 Brazil
                                                </option>
                                                <option value="flag-icon-bs"
                                                    {{ old('flag_icon') == 'flag-icon-bs' ? 'selected' : '' }}>🇧🇸 Bahamas
                                                </option>
                                                <option value="flag-icon-bt"
                                                    {{ old('flag_icon') == 'flag-icon-bt' ? 'selected' : '' }}>🇧🇹 Bhutan
                                                </option>
                                                <option value="flag-icon-bv"
                                                    {{ old('flag_icon') == 'flag-icon-bv' ? 'selected' : '' }}>🇧🇻 Bouvet
                                                    Island</option>
                                                <option value="flag-icon-bw"
                                                    {{ old('flag_icon') == 'flag-icon-bw' ? 'selected' : '' }}>🇧🇼
                                                    Botswana</option>
                                                <option value="flag-icon-by"
                                                    {{ old('flag_icon') == 'flag-icon-by' ? 'selected' : '' }}>🇧🇾 Belarus
                                                </option>
                                                <option value="flag-icon-bz"
                                                    {{ old('flag_icon') == 'flag-icon-bz' ? 'selected' : '' }}>🇧🇿 Belize
                                                </option>
                                                <option value="flag-icon-ca"
                                                    {{ old('flag_icon') == 'flag-icon-ca' ? 'selected' : '' }}>🇨🇦 Canada
                                                </option>
                                                <option value="flag-icon-cc"
                                                    {{ old('flag_icon') == 'flag-icon-cc' ? 'selected' : '' }}>🇨🇨 Cocos
                                                    Islands</option>
                                                <option value="flag-icon-cd"
                                                    {{ old('flag_icon') == 'flag-icon-cd' ? 'selected' : '' }}>🇨🇩
                                                    Democratic Republic of the Congo</option>
                                                <option value="flag-icon-cf"
                                                    {{ old('flag_icon') == 'flag-icon-cf' ? 'selected' : '' }}>🇨🇫 Central
                                                    African Republic</option>
                                                <option value="flag-icon-cg"
                                                    {{ old('flag_icon') == 'flag-icon-cg' ? 'selected' : '' }}>🇨🇬
                                                    Republic of the Congo</option>
                                                <option value="flag-icon-ch"
                                                    {{ old('flag_icon') == 'flag-icon-ch' ? 'selected' : '' }}>🇨🇭
                                                    Switzerland</option>
                                                <option value="flag-icon-ci"
                                                    {{ old('flag_icon') == 'flag-icon-ci' ? 'selected' : '' }}>🇨🇮 Côte
                                                    d'Ivoire</option>
                                                <option value="flag-icon-ck"
                                                    {{ old('flag_icon') == 'flag-icon-ck' ? 'selected' : '' }}>🇨🇰 Cook
                                                    Islands</option>
                                                <option value="flag-icon-cl"
                                                    {{ old('flag_icon') == 'flag-icon-cl' ? 'selected' : '' }}>🇨🇱 Chile
                                                </option>
                                                <option value="flag-icon-cm"
                                                    {{ old('flag_icon') == 'flag-icon-cm' ? 'selected' : '' }}>🇨🇲
                                                    Cameroon</option>
                                                <option value="flag-icon-cn"
                                                    {{ old('flag_icon') == 'flag-icon-cn' ? 'selected' : '' }}>🇨🇳 China
                                                </option>
                                                <option value="flag-icon-co"
                                                    {{ old('flag_icon') == 'flag-icon-co' ? 'selected' : '' }}>🇨🇴
                                                    Colombia</option>
                                                <option value="flag-icon-cr"
                                                    {{ old('flag_icon') == 'flag-icon-cr' ? 'selected' : '' }}>🇨🇷 Costa
                                                    Rica</option>
                                                <option value="flag-icon-cu"
                                                    {{ old('flag_icon') == 'flag-icon-cu' ? 'selected' : '' }}>🇨🇺 Cuba
                                                </option>
                                                <option value="flag-icon-cv"
                                                    {{ old('flag_icon') == 'flag-icon-cv' ? 'selected' : '' }}>🇨🇻 Cape
                                                    Verde</option>
                                                <option value="flag-icon-cw"
                                                    {{ old('flag_icon') == 'flag-icon-cw' ? 'selected' : '' }}>🇨🇼 Curaçao
                                                </option>
                                                <option value="flag-icon-cx"
                                                    {{ old('flag_icon') == 'flag-icon-cx' ? 'selected' : '' }}>🇨🇽
                                                    Christmas Island</option>
                                                <option value="flag-icon-cy"
                                                    {{ old('flag_icon') == 'flag-icon-cy' ? 'selected' : '' }}>🇨🇾 Cyprus
                                                </option>
                                                <option value="flag-icon-cz"
                                                    {{ old('flag_icon') == 'flag-icon-cz' ? 'selected' : '' }}>🇨🇿 Czech
                                                    Republic</option>
                                                <option value="flag-icon-de"
                                                    {{ old('flag_icon') == 'flag-icon-de' ? 'selected' : '' }}>🇩🇪 Germany
                                                </option>
                                                <option value="flag-icon-dj"
                                                    {{ old('flag_icon') == 'flag-icon-dj' ? 'selected' : '' }}>🇩🇯
                                                    Djibouti</option>
                                                <option value="flag-icon-dk"
                                                    {{ old('flag_icon') == 'flag-icon-dk' ? 'selected' : '' }}>🇩🇰 Denmark
                                                </option>
                                                <option value="flag-icon-dm"
                                                    {{ old('flag_icon') == 'flag-icon-dm' ? 'selected' : '' }}>🇩🇲
                                                    Dominica</option>
                                                <option value="flag-icon-do"
                                                    {{ old('flag_icon') == 'flag-icon-do' ? 'selected' : '' }}>🇩🇴
                                                    Dominican Republic</option>
                                                <option value="flag-icon-dz"
                                                    {{ old('flag_icon') == 'flag-icon-dz' ? 'selected' : '' }}>🇩🇿 Algeria
                                                </option>
                                                <option value="flag-icon-ec"
                                                    {{ old('flag_icon') == 'flag-icon-ec' ? 'selected' : '' }}>🇪🇨 Ecuador
                                                </option>
                                                <option value="flag-icon-ee"
                                                    {{ old('flag_icon') == 'flag-icon-ee' ? 'selected' : '' }}>🇪🇪 Estonia
                                                </option>
                                                <option value="flag-icon-eg"
                                                    {{ old('flag_icon') == 'flag-icon-eg' ? 'selected' : '' }}>🇪🇬 Egypt
                                                </option>
                                                <option value="flag-icon-eh"
                                                    {{ old('flag_icon') == 'flag-icon-eh' ? 'selected' : '' }}>🇪🇭 Western
                                                    Sahara</option>
                                                <option value="flag-icon-er"
                                                    {{ old('flag_icon') == 'flag-icon-er' ? 'selected' : '' }}>🇪🇷 Eritrea
                                                </option>
                                                <option value="flag-icon-es"
                                                    {{ old('flag_icon') == 'flag-icon-es' ? 'selected' : '' }}>🇪🇸 Spain
                                                </option>
                                                <option value="flag-icon-et"
                                                    {{ old('flag_icon') == 'flag-icon-et' ? 'selected' : '' }}>🇪🇹
                                                    Ethiopia</option>
                                                <option value="flag-icon-fi"
                                                    {{ old('flag_icon') == 'flag-icon-fi' ? 'selected' : '' }}>🇫🇮 Finland
                                                </option>
                                                <option value="flag-icon-fj"
                                                    {{ old('flag_icon') == 'flag-icon-fj' ? 'selected' : '' }}>🇫🇯 Fiji
                                                </option>
                                                <option value="flag-icon-fk"
                                                    {{ old('flag_icon') == 'flag-icon-fk' ? 'selected' : '' }}>🇫🇰
                                                    Falkland Islands</option>
                                                <option value="flag-icon-fm"
                                                    {{ old('flag_icon') == 'flag-icon-fm' ? 'selected' : '' }}>🇫🇲
                                                    Micronesia</option>
                                                <option value="flag-icon-fo"
                                                    {{ old('flag_icon') == 'flag-icon-fo' ? 'selected' : '' }}>🇫🇴 Faroe
                                                    Islands</option>
                                                <option value="flag-icon-fr"
                                                    {{ old('flag_icon') == 'flag-icon-fr' ? 'selected' : '' }}>🇫🇷 France
                                                </option>
                                                <option value="flag-icon-ga"
                                                    {{ old('flag_icon') == 'flag-icon-ga' ? 'selected' : '' }}>🇬🇦 Gabon
                                                </option>
                                                <option value="flag-icon-gb"
                                                    {{ old('flag_icon') == 'flag-icon-gb' ? 'selected' : '' }}>🇬🇧 United
                                                    Kingdom</option>
                                                <option value="flag-icon-gd"
                                                    {{ old('flag_icon') == 'flag-icon-gd' ? 'selected' : '' }}>🇬🇩 Grenada
                                                </option>
                                                <option value="flag-icon-ge"
                                                    {{ old('flag_icon') == 'flag-icon-ge' ? 'selected' : '' }}>🇬🇪 Georgia
                                                </option>
                                                <option value="flag-icon-gf"
                                                    {{ old('flag_icon') == 'flag-icon-gf' ? 'selected' : '' }}>🇬🇫 French
                                                    Guiana</option>
                                                <option value="flag-icon-gg"
                                                    {{ old('flag_icon') == 'flag-icon-gg' ? 'selected' : '' }}>🇬🇬
                                                    Guernsey</option>
                                                <option value="flag-icon-gh"
                                                    {{ old('flag_icon') == 'flag-icon-gh' ? 'selected' : '' }}>🇬🇭 Ghana
                                                </option>
                                                <option value="flag-icon-gi"
                                                    {{ old('flag_icon') == 'flag-icon-gi' ? 'selected' : '' }}>🇬🇮
                                                    Gibraltar</option>
                                                <option value="flag-icon-gl"
                                                    {{ old('flag_icon') == 'flag-icon-gl' ? 'selected' : '' }}>🇬🇱
                                                    Greenland</option>
                                                <option value="flag-icon-gm"
                                                    {{ old('flag_icon') == 'flag-icon-gm' ? 'selected' : '' }}>🇬🇲 Gambia
                                                </option>
                                                <option value="flag-icon-gn"
                                                    {{ old('flag_icon') == 'flag-icon-gn' ? 'selected' : '' }}>🇬🇳 Guinea
                                                </option>
                                                <option value="flag-icon-gp"
                                                    {{ old('flag_icon') == 'flag-icon-gp' ? 'selected' : '' }}>🇬🇵
                                                    Guadeloupe</option>
                                                <option value="flag-icon-gq"
                                                    {{ old('flag_icon') == 'flag-icon-gq' ? 'selected' : '' }}>🇬🇶
                                                    Equatorial Guinea</option>
                                                <option value="flag-icon-gr"
                                                    {{ old('flag_icon') == 'flag-icon-gr' ? 'selected' : '' }}>🇬🇷 Greece
                                                </option>
                                                <option value="flag-icon-gs"
                                                    {{ old('flag_icon') == 'flag-icon-gs' ? 'selected' : '' }}>🇬🇸 South
                                                    Georgia</option>
                                                <option value="flag-icon-gt"
                                                    {{ old('flag_icon') == 'flag-icon-gt' ? 'selected' : '' }}>🇬🇹
                                                    Guatemala</option>
                                                <option value="flag-icon-gu"
                                                    {{ old('flag_icon') == 'flag-icon-gu' ? 'selected' : '' }}>🇬🇺 Guam
                                                </option>
                                                <option value="flag-icon-gw"
                                                    {{ old('flag_icon') == 'flag-icon-gw' ? 'selected' : '' }}>🇬🇼
                                                    Guinea-Bissau</option>
                                                <option value="flag-icon-gy"
                                                    {{ old('flag_icon') == 'flag-icon-gy' ? 'selected' : '' }}>🇬🇾 Guyana
                                                </option>
                                                <option value="flag-icon-hk"
                                                    {{ old('flag_icon') == 'flag-icon-hk' ? 'selected' : '' }}>🇭🇰 Hong
                                                    Kong</option>
                                                <option value="flag-icon-hm"
                                                    {{ old('flag_icon') == 'flag-icon-hm' ? 'selected' : '' }}>🇭🇲 Heard
                                                    Island</option>
                                                <option value="flag-icon-hn"
                                                    {{ old('flag_icon') == 'flag-icon-hn' ? 'selected' : '' }}>🇭🇳
                                                    Honduras</option>
                                                <option value="flag-icon-hr"
                                                    {{ old('flag_icon') == 'flag-icon-hr' ? 'selected' : '' }}>🇭🇷
                                                    Croatia</option>
                                                <option value="flag-icon-ht"
                                                    {{ old('flag_icon') == 'flag-icon-ht' ? 'selected' : '' }}>🇭🇹 Haiti
                                                </option>
                                                <option value="flag-icon-hu"
                                                    {{ old('flag_icon') == 'flag-icon-hu' ? 'selected' : '' }}>🇭🇺
                                                    Hungary</option>
                                                <option value="flag-icon-id"
                                                    {{ old('flag_icon') == 'flag-icon-id' ? 'selected' : '' }}>🇮🇩
                                                    Indonesia</option>
                                                <option value="flag-icon-ie"
                                                    {{ old('flag_icon') == 'flag-icon-ie' ? 'selected' : '' }}>🇮🇪
                                                    Ireland</option>
                                                <option value="flag-icon-il"
                                                    {{ old('flag_icon') == 'flag-icon-il' ? 'selected' : '' }}>🇮🇱 Israel
                                                </option>
                                                <option value="flag-icon-im"
                                                    {{ old('flag_icon') == 'flag-icon-im' ? 'selected' : '' }}>🇮🇲 Isle
                                                    of Man</option>
                                                <option value="flag-icon-in"
                                                    {{ old('flag_icon') == 'flag-icon-in' ? 'selected' : '' }}>🇮🇳 India
                                                </option>
                                                <option value="flag-icon-io"
                                                    {{ old('flag_icon') == 'flag-icon-io' ? 'selected' : '' }}>🇮🇴
                                                    British Indian Ocean Territory</option>
                                                <option value="flag-icon-iq"
                                                    {{ old('flag_icon') == 'flag-icon-iq' ? 'selected' : '' }}>🇮🇶 Iraq
                                                </option>
                                                <option value="flag-icon-ir"
                                                    {{ old('flag_icon') == 'flag-icon-ir' ? 'selected' : '' }}>🇮🇷 Iran
                                                </option>
                                                <option value="flag-icon-is"
                                                    {{ old('flag_icon') == 'flag-icon-is' ? 'selected' : '' }}>🇮🇸
                                                    Iceland</option>
                                                <option value="flag-icon-it"
                                                    {{ old('flag_icon') == 'flag-icon-it' ? 'selected' : '' }}>🇮🇹 Italy
                                                </option>
                                                <option value="flag-icon-je"
                                                    {{ old('flag_icon') == 'flag-icon-je' ? 'selected' : '' }}>🇯🇪 Jersey
                                                </option>
                                                <option value="flag-icon-jm"
                                                    {{ old('flag_icon') == 'flag-icon-jm' ? 'selected' : '' }}>🇯🇲
                                                    Jamaica</option>
                                                <option value="flag-icon-jo"
                                                    {{ old('flag_icon') == 'flag-icon-jo' ? 'selected' : '' }}>🇯🇴 Jordan
                                                </option>
                                                <option value="flag-icon-jp"
                                                    {{ old('flag_icon') == 'flag-icon-jp' ? 'selected' : '' }}>🇯🇵 Japan
                                                </option>
                                                <option value="flag-icon-ke"
                                                    {{ old('flag_icon') == 'flag-icon-ke' ? 'selected' : '' }}>🇰🇪 Kenya
                                                </option>
                                                <option value="flag-icon-kg"
                                                    {{ old('flag_icon') == 'flag-icon-kg' ? 'selected' : '' }}>🇰🇬
                                                    Kyrgyzstan</option>
                                                <option value="flag-icon-kh"
                                                    {{ old('flag_icon') == 'flag-icon-kh' ? 'selected' : '' }}>🇰🇭
                                                    Cambodia</option>
                                                <option value="flag-icon-ki"
                                                    {{ old('flag_icon') == 'flag-icon-ki' ? 'selected' : '' }}>🇰🇮
                                                    Kiribati</option>
                                                <option value="flag-icon-km"
                                                    {{ old('flag_icon') == 'flag-icon-km' ? 'selected' : '' }}>🇰🇲
                                                    Comoros</option>
                                                <option value="flag-icon-kn"
                                                    {{ old('flag_icon') == 'flag-icon-kn' ? 'selected' : '' }}>🇰🇳 Saint
                                                    Kitts and Nevis</option>
                                                <option value="flag-icon-kp"
                                                    {{ old('flag_icon') == 'flag-icon-kp' ? 'selected' : '' }}>🇰🇵 North
                                                    Korea</option>
                                                <option value="flag-icon-kr"
                                                    {{ old('flag_icon') == 'flag-icon-kr' ? 'selected' : '' }}>🇰🇷 South
                                                    Korea</option>
                                                <option value="flag-icon-kw"
                                                    {{ old('flag_icon') == 'flag-icon-kw' ? 'selected' : '' }}>🇰🇼 Kuwait
                                                </option>
                                                <option value="flag-icon-ky"
                                                    {{ old('flag_icon') == 'flag-icon-ky' ? 'selected' : '' }}>🇰🇾 Cayman
                                                    Islands</option>
                                                <option value="flag-icon-kz"
                                                    {{ old('flag_icon') == 'flag-icon-kz' ? 'selected' : '' }}>🇰🇿
                                                    Kazakhstan</option>
                                                <option value="flag-icon-la"
                                                    {{ old('flag_icon') == 'flag-icon-la' ? 'selected' : '' }}>🇱🇦 Laos
                                                </option>
                                                <option value="flag-icon-lb"
                                                    {{ old('flag_icon') == 'flag-icon-lb' ? 'selected' : '' }}>🇱🇧
                                                    Lebanon</option>
                                                <option value="flag-icon-lc"
                                                    {{ old('flag_icon') == 'flag-icon-lc' ? 'selected' : '' }}>🇱🇨 Saint
                                                    Lucia</option>
                                                <option value="flag-icon-li"
                                                    {{ old('flag_icon') == 'flag-icon-li' ? 'selected' : '' }}>🇱🇮
                                                    Liechtenstein</option>
                                                <option value="flag-icon-lk"
                                                    {{ old('flag_icon') == 'flag-icon-lk' ? 'selected' : '' }}>🇱🇰 Sri
                                                    Lanka</option>
                                                <option value="flag-icon-lr"
                                                    {{ old('flag_icon') == 'flag-icon-lr' ? 'selected' : '' }}>🇱🇷
                                                    Liberia</option>
                                                <option value="flag-icon-ls"
                                                    {{ old('flag_icon') == 'flag-icon-ls' ? 'selected' : '' }}>🇱🇸
                                                    Lesotho</option>
                                                <option value="flag-icon-lt"
                                                    {{ old('flag_icon') == 'flag-icon-lt' ? 'selected' : '' }}>🇱🇹
                                                    Lithuania</option>
                                                <option value="flag-icon-lu"
                                                    {{ old('flag_icon') == 'flag-icon-lu' ? 'selected' : '' }}>🇱🇺
                                                    Luxembourg</option>
                                                <option value="flag-icon-lv"
                                                    {{ old('flag_icon') == 'flag-icon-lv' ? 'selected' : '' }}>🇱🇻 Latvia
                                                </option>
                                                <option value="flag-icon-ly"
                                                    {{ old('flag_icon') == 'flag-icon-ly' ? 'selected' : '' }}>🇱🇾 Libya
                                                </option>
                                                <option value="flag-icon-ma"
                                                    {{ old('flag_icon') == 'flag-icon-ma' ? 'selected' : '' }}>🇲🇦
                                                    Morocco</option>
                                                <option value="flag-icon-mc"
                                                    {{ old('flag_icon') == 'flag-icon-mc' ? 'selected' : '' }}>🇲🇨 Monaco
                                                </option>
                                                <option value="flag-icon-md"
                                                    {{ old('flag_icon') == 'flag-icon-md' ? 'selected' : '' }}>🇲🇩
                                                    Moldova</option>
                                                <option value="flag-icon-me"
                                                    {{ old('flag_icon') == 'flag-icon-me' ? 'selected' : '' }}>🇲🇪
                                                    Montenegro</option>
                                                <option value="flag-icon-mf"
                                                    {{ old('flag_icon') == 'flag-icon-mf' ? 'selected' : '' }}>🇲🇫 Saint
                                                    Martin</option>
                                                <option value="flag-icon-mg"
                                                    {{ old('flag_icon') == 'flag-icon-mg' ? 'selected' : '' }}>🇲🇬
                                                    Madagascar</option>
                                                <option value="flag-icon-mh"
                                                    {{ old('flag_icon') == 'flag-icon-mh' ? 'selected' : '' }}>🇲🇭
                                                    Marshall Islands</option>
                                                <option value="flag-icon-mk"
                                                    {{ old('flag_icon') == 'flag-icon-mk' ? 'selected' : '' }}>🇲🇰 North
                                                    Macedonia</option>
                                                <option value="flag-icon-ml"
                                                    {{ old('flag_icon') == 'flag-icon-ml' ? 'selected' : '' }}>🇲🇱 Mali
                                                </option>
                                                <option value="flag-icon-mm"
                                                    {{ old('flag_icon') == 'flag-icon-mm' ? 'selected' : '' }}>🇲🇲
                                                    Myanmar</option>
                                                <option value="flag-icon-mn"
                                                    {{ old('flag_icon') == 'flag-icon-mn' ? 'selected' : '' }}>🇲🇳
                                                    Mongolia</option>
                                                <option value="flag-icon-mo"
                                                    {{ old('flag_icon') == 'flag-icon-mo' ? 'selected' : '' }}>🇲🇴 Macao
                                                </option>
                                                <option value="flag-icon-mp"
                                                    {{ old('flag_icon') == 'flag-icon-mp' ? 'selected' : '' }}>🇲🇵
                                                    Northern Mariana Islands</option>
                                                <option value="flag-icon-mq"
                                                    {{ old('flag_icon') == 'flag-icon-mq' ? 'selected' : '' }}>🇲🇶
                                                    Martinique</option>
                                                <option value="flag-icon-mr"
                                                    {{ old('flag_icon') == 'flag-icon-mr' ? 'selected' : '' }}>🇲🇷
                                                    Mauritania</option>
                                                <option value="flag-icon-ms"
                                                    {{ old('flag_icon') == 'flag-icon-ms' ? 'selected' : '' }}>🇲🇸
                                                    Montserrat</option>
                                                <option value="flag-icon-mt"
                                                    {{ old('flag_icon') == 'flag-icon-mt' ? 'selected' : '' }}>🇲🇹 Malta
                                                </option>
                                                <option value="flag-icon-mu"
                                                    {{ old('flag_icon') == 'flag-icon-mu' ? 'selected' : '' }}>🇲🇺
                                                    Mauritius</option>
                                                <option value="flag-icon-mv"
                                                    {{ old('flag_icon') == 'flag-icon-mv' ? 'selected' : '' }}>🇲🇻
                                                    Maldives</option>
                                                <option value="flag-icon-mw"
                                                    {{ old('flag_icon') == 'flag-icon-mw' ? 'selected' : '' }}>🇲🇼 Malawi
                                                </option>
                                                <option value="flag-icon-mx"
                                                    {{ old('flag_icon') == 'flag-icon-mx' ? 'selected' : '' }}>🇲🇽 Mexico
                                                </option>
                                                <option value="flag-icon-my"
                                                    {{ old('flag_icon') == 'flag-icon-my' ? 'selected' : '' }}>🇲🇾
                                                    Malaysia</option>
                                                <option value="flag-icon-mz"
                                                    {{ old('flag_icon') == 'flag-icon-mz' ? 'selected' : '' }}>🇲🇿
                                                    Mozambique</option>
                                                <option value="flag-icon-na"
                                                    {{ old('flag_icon') == 'flag-icon-na' ? 'selected' : '' }}>🇳🇦
                                                    Namibia</option>
                                                <option value="flag-icon-nc"
                                                    {{ old('flag_icon') == 'flag-icon-nc' ? 'selected' : '' }}>🇳🇨 New
                                                    Caledonia</option>
                                                <option value="flag-icon-ne"
                                                    {{ old('flag_icon') == 'flag-icon-ne' ? 'selected' : '' }}>🇳🇪 Niger
                                                </option>
                                                <option value="flag-icon-nf"
                                                    {{ old('flag_icon') == 'flag-icon-nf' ? 'selected' : '' }}>🇳🇫
                                                    Norfolk Island</option>
                                                <option value="flag-icon-ng"
                                                    {{ old('flag_icon') == 'flag-icon-ng' ? 'selected' : '' }}>🇳🇬
                                                    Nigeria</option>
                                                <option value="flag-icon-ni"
                                                    {{ old('flag_icon') == 'flag-icon-ni' ? 'selected' : '' }}>🇳🇮
                                                    Nicaragua</option>
                                                <option value="flag-icon-nl"
                                                    {{ old('flag_icon') == 'flag-icon-nl' ? 'selected' : '' }}>🇳🇱
                                                    Netherlands</option>
                                                <option value="flag-icon-no"
                                                    {{ old('flag_icon') == 'flag-icon-no' ? 'selected' : '' }}>🇳🇴 Norway
                                                </option>
                                                <option value="flag-icon-np"
                                                    {{ old('flag_icon') == 'flag-icon-np' ? 'selected' : '' }}>🇳🇵 Nepal
                                                </option>
                                                <option value="flag-icon-nr"
                                                    {{ old('flag_icon') == 'flag-icon-nr' ? 'selected' : '' }}>🇳🇷 Nauru
                                                </option>
                                                <option value="flag-icon-nu"
                                                    {{ old('flag_icon') == 'flag-icon-nu' ? 'selected' : '' }}>🇳🇺 Niue
                                                </option>
                                                <option value="flag-icon-nz"
                                                    {{ old('flag_icon') == 'flag-icon-nz' ? 'selected' : '' }}>🇳🇿 New
                                                    Zealand</option>
                                                <option value="flag-icon-om"
                                                    {{ old('flag_icon') == 'flag-icon-om' ? 'selected' : '' }}>🇴🇲 Oman
                                                </option>
                                                <option value="flag-icon-pa"
                                                    {{ old('flag_icon') == 'flag-icon-pa' ? 'selected' : '' }}>🇵🇦 Panama
                                                </option>
                                                <option value="flag-icon-pe"
                                                    {{ old('flag_icon') == 'flag-icon-pe' ? 'selected' : '' }}>🇵🇪 Peru
                                                </option>
                                                <option value="flag-icon-pf"
                                                    {{ old('flag_icon') == 'flag-icon-pf' ? 'selected' : '' }}>🇵🇫 French
                                                    Polynesia</option>
                                                <option value="flag-icon-pg"
                                                    {{ old('flag_icon') == 'flag-icon-pg' ? 'selected' : '' }}>🇵🇬 Papua
                                                    New Guinea</option>
                                                <option value="flag-icon-ph"
                                                    {{ old('flag_icon') == 'flag-icon-ph' ? 'selected' : '' }}>🇵🇭
                                                    Philippines</option>
                                                <option value="flag-icon-pk"
                                                    {{ old('flag_icon') == 'flag-icon-pk' ? 'selected' : '' }}>🇵🇰
                                                    Pakistan</option>
                                                <option value="flag-icon-pl"
                                                    {{ old('flag_icon') == 'flag-icon-pl' ? 'selected' : '' }}>🇵🇱 Poland
                                                </option>
                                                <option value="flag-icon-pm"
                                                    {{ old('flag_icon') == 'flag-icon-pm' ? 'selected' : '' }}>🇵🇲 Saint
                                                    Pierre and Miquelon</option>
                                                <option value="flag-icon-pn"
                                                    {{ old('flag_icon') == 'flag-icon-pn' ? 'selected' : '' }}>🇵🇳
                                                    Pitcairn</option>
                                                <option value="flag-icon-pr"
                                                    {{ old('flag_icon') == 'flag-icon-pr' ? 'selected' : '' }}>🇵🇷 Puerto
                                                    Rico</option>
                                                <option value="flag-icon-ps"
                                                    {{ old('flag_icon') == 'flag-icon-ps' ? 'selected' : '' }}>🇵🇸
                                                    Palestine</option>
                                                <option value="flag-icon-pt"
                                                    {{ old('flag_icon') == 'flag-icon-pt' ? 'selected' : '' }}>🇵🇹
                                                    Portugal</option>
                                                <option value="flag-icon-pw"
                                                    {{ old('flag_icon') == 'flag-icon-pw' ? 'selected' : '' }}>🇵🇼 Palau
                                                </option>
                                                <option value="flag-icon-py"
                                                    {{ old('flag_icon') == 'flag-icon-py' ? 'selected' : '' }}>🇵🇾
                                                    Paraguay</option>
                                                <option value="flag-icon-qa"
                                                    {{ old('flag_icon') == 'flag-icon-qa' ? 'selected' : '' }}>🇶🇦 Qatar
                                                </option>
                                                <option value="flag-icon-re"
                                                    {{ old('flag_icon') == 'flag-icon-re' ? 'selected' : '' }}>🇷🇪
                                                    Réunion</option>
                                                <option value="flag-icon-ro"
                                                    {{ old('flag_icon') == 'flag-icon-ro' ? 'selected' : '' }}>🇷🇴
                                                    Romania</option>
                                                <option value="flag-icon-rs"
                                                    {{ old('flag_icon') == 'flag-icon-rs' ? 'selected' : '' }}>🇷🇸 Serbia
                                                </option>
                                                <option value="flag-icon-ru"
                                                    {{ old('flag_icon') == 'flag-icon-ru' ? 'selected' : '' }}>🇷🇺 Russia
                                                </option>
                                                <option value="flag-icon-rw"
                                                    {{ old('flag_icon') == 'flag-icon-rw' ? 'selected' : '' }}>🇷🇼 Rwanda
                                                </option>
                                                <option value="flag-icon-sa"
                                                    {{ old('flag_icon') == 'flag-icon-sa' ? 'selected' : '' }}>🇸🇦 Saudi
                                                    Arabia</option>
                                                <option value="flag-icon-sb"
                                                    {{ old('flag_icon') == 'flag-icon-sb' ? 'selected' : '' }}>🇸🇧
                                                    Solomon Islands</option>
                                                <option value="flag-icon-sc"
                                                    {{ old('flag_icon') == 'flag-icon-sc' ? 'selected' : '' }}>🇸🇨
                                                    Seychelles</option>
                                                <option value="flag-icon-sd"
                                                    {{ old('flag_icon') == 'flag-icon-sd' ? 'selected' : '' }}>🇸🇩 Sudan
                                                </option>
                                                <option value="flag-icon-se"
                                                    {{ old('flag_icon') == 'flag-icon-se' ? 'selected' : '' }}>🇸🇪 Sweden
                                                </option>
                                                <option value="flag-icon-sg"
                                                    {{ old('flag_icon') == 'flag-icon-sg' ? 'selected' : '' }}>🇸🇬
                                                    Singapore</option>
                                                <option value="flag-icon-sh"
                                                    {{ old('flag_icon') == 'flag-icon-sh' ? 'selected' : '' }}>🇸🇭 Saint
                                                    Helena</option>
                                                <option value="flag-icon-si"
                                                    {{ old('flag_icon') == 'flag-icon-si' ? 'selected' : '' }}>🇸🇮
                                                    Slovenia</option>
                                                <option value="flag-icon-sj"
                                                    {{ old('flag_icon') == 'flag-icon-sj' ? 'selected' : '' }}>🇸🇯
                                                    Svalbard and Jan Mayen</option>
                                                <option value="flag-icon-sk"
                                                    {{ old('flag_icon') == 'flag-icon-sk' ? 'selected' : '' }}>🇸🇰
                                                    Slovakia</option>
                                                <option value="flag-icon-sl"
                                                    {{ old('flag_icon') == 'flag-icon-sl' ? 'selected' : '' }}>🇸🇱 Sierra
                                                    Leone</option>
                                                <option value="flag-icon-sm"
                                                    {{ old('flag_icon') == 'flag-icon-sm' ? 'selected' : '' }}>🇸🇲 San
                                                    Marino</option>
                                                <option value="flag-icon-sn"
                                                    {{ old('flag_icon') == 'flag-icon-sn' ? 'selected' : '' }}>🇸🇳
                                                    Senegal</option>
                                                <option value="flag-icon-so"
                                                    {{ old('flag_icon') == 'flag-icon-so' ? 'selected' : '' }}>🇸🇴
                                                    Somalia</option>
                                                <option value="flag-icon-sr"
                                                    {{ old('flag_icon') == 'flag-icon-sr' ? 'selected' : '' }}>🇸🇷
                                                    Suriname</option>
                                                <option value="flag-icon-ss"
                                                    {{ old('flag_icon') == 'flag-icon-ss' ? 'selected' : '' }}>🇸🇸 South
                                                    Sudan</option>
                                                <option value="flag-icon-st"
                                                    {{ old('flag_icon') == 'flag-icon-st' ? 'selected' : '' }}>🇸🇹 São
                                                    Tomé and Príncipe</option>
                                                <option value="flag-icon-sv"
                                                    {{ old('flag_icon') == 'flag-icon-sv' ? 'selected' : '' }}>🇸🇻 El
                                                    Salvador</option>
                                                <option value="flag-icon-sx"
                                                    {{ old('flag_icon') == 'flag-icon-sx' ? 'selected' : '' }}>🇸🇽 Sint
                                                    Maarten</option>
                                                <option value="flag-icon-sy"
                                                    {{ old('flag_icon') == 'flag-icon-sy' ? 'selected' : '' }}>🇸🇾 Syria
                                                </option>
                                                <option value="flag-icon-sz"
                                                    {{ old('flag_icon') == 'flag-icon-sz' ? 'selected' : '' }}>🇸🇿
                                                    Eswatini</option>
                                                <option value="flag-icon-tc"
                                                    {{ old('flag_icon') == 'flag-icon-tc' ? 'selected' : '' }}>🇹🇨 Turks
                                                    and Caicos Islands</option>
                                                <option value="flag-icon-td"
                                                    {{ old('flag_icon') == 'flag-icon-td' ? 'selected' : '' }}>🇹🇩 Chad
                                                </option>
                                                <option value="flag-icon-tf"
                                                    {{ old('flag_icon') == 'flag-icon-tf' ? 'selected' : '' }}>🇹🇫 French
                                                    Southern Territories</option>
                                                <option value="flag-icon-tg"
                                                    {{ old('flag_icon') == 'flag-icon-tg' ? 'selected' : '' }}>🇹🇬 Togo
                                                </option>
                                                <option value="flag-icon-th"
                                                    {{ old('flag_icon') == 'flag-icon-th' ? 'selected' : '' }}>🇹🇭
                                                    Thailand</option>
                                                <option value="flag-icon-tj"
                                                    {{ old('flag_icon') == 'flag-icon-tj' ? 'selected' : '' }}>🇹🇯
                                                    Tajikistan</option>
                                                <option value="flag-icon-tk"
                                                    {{ old('flag_icon') == 'flag-icon-tk' ? 'selected' : '' }}>🇹🇰
                                                    Tokelau</option>
                                                <option value="flag-icon-tl"
                                                    {{ old('flag_icon') == 'flag-icon-tl' ? 'selected' : '' }}>🇹🇱
                                                    Timor-Leste</option>
                                                <option value="flag-icon-tm"
                                                    {{ old('flag_icon') == 'flag-icon-tm' ? 'selected' : '' }}>🇹🇲
                                                    Turkmenistan</option>
                                                <option value="flag-icon-tn"
                                                    {{ old('flag_icon') == 'flag-icon-tn' ? 'selected' : '' }}>🇹🇳
                                                    Tunisia</option>
                                                <option value="flag-icon-to"
                                                    {{ old('flag_icon') == 'flag-icon-to' ? 'selected' : '' }}>🇹🇴 Tonga
                                                </option>
                                                <option value="flag-icon-tr"
                                                    {{ old('flag_icon') == 'flag-icon-tr' ? 'selected' : '' }}>🇹🇷 Turkey
                                                </option>
                                                <option value="flag-icon-tt"
                                                    {{ old('flag_icon') == 'flag-icon-tt' ? 'selected' : '' }}>🇹🇹
                                                    Trinidad and Tobago</option>
                                                <option value="flag-icon-tv"
                                                    {{ old('flag_icon') == 'flag-icon-tv' ? 'selected' : '' }}>🇹🇻 Tuvalu
                                                </option>
                                                <option value="flag-icon-tw"
                                                    {{ old('flag_icon') == 'flag-icon-tw' ? 'selected' : '' }}>🇹🇼 Taiwan
                                                </option>
                                                <option value="flag-icon-tz"
                                                    {{ old('flag_icon') == 'flag-icon-tz' ? 'selected' : '' }}>🇹🇿
                                                    Tanzania</option>
                                                <option value="flag-icon-ua"
                                                    {{ old('flag_icon') == 'flag-icon-ua' ? 'selected' : '' }}>🇺🇦
                                                    Ukraine</option>
                                                <option value="flag-icon-ug"
                                                    {{ old('flag_icon') == 'flag-icon-ug' ? 'selected' : '' }}>🇺🇬 Uganda
                                                </option>
                                                <option value="flag-icon-um"
                                                    {{ old('flag_icon') == 'flag-icon-um' ? 'selected' : '' }}>🇺🇲 U.S.
                                                    Outlying Islands</option>
                                                <option value="flag-icon-us"
                                                    {{ old('flag_icon') == 'flag-icon-us' ? 'selected' : '' }}>🇺🇸 United
                                                    States</option>
                                                <option value="flag-icon-uy"
                                                    {{ old('flag_icon') == 'flag-icon-uy' ? 'selected' : '' }}>🇺🇾
                                                    Uruguay</option>
                                                <option value="flag-icon-uz"
                                                    {{ old('flag_icon') == 'flag-icon-uz' ? 'selected' : '' }}>🇺🇿
                                                    Uzbekistan</option>
                                                <option value="flag-icon-va"
                                                    {{ old('flag_icon') == 'flag-icon-va' ? 'selected' : '' }}>🇻🇦
                                                    Vatican City</option>
                                                <option value="flag-icon-vc"
                                                    {{ old('flag_icon') == 'flag-icon-vc' ? 'selected' : '' }}>🇻🇨 Saint
                                                    Vincent and the Grenadines</option>
                                                <option value="flag-icon-ve"
                                                    {{ old('flag_icon') == 'flag-icon-ve' ? 'selected' : '' }}>🇻🇪
                                                    Venezuela</option>
                                                <option value="flag-icon-vg"
                                                    {{ old('flag_icon') == 'flag-icon-vg' ? 'selected' : '' }}>🇻🇬
                                                    British Virgin Islands</option>
                                                <option value="flag-icon-vi"
                                                    {{ old('flag_icon') == 'flag-icon-vi' ? 'selected' : '' }}>🇻🇮 U.S.
                                                    Virgin Islands</option>
                                                <option value="flag-icon-vn"
                                                    {{ old('flag_icon') == 'flag-icon-vn' ? 'selected' : '' }}>🇻🇳
                                                    Vietnam</option>
                                                <option value="flag-icon-vu"
                                                    {{ old('flag_icon') == 'flag-icon-vu' ? 'selected' : '' }}>🇻🇺
                                                    Vanuatu</option>
                                                <option value="flag-icon-wf"
                                                    {{ old('flag_icon') == 'flag-icon-wf' ? 'selected' : '' }}>🇼🇫 Wallis
                                                    and Futuna</option>
                                                <option value="flag-icon-ws"
                                                    {{ old('flag_icon') == 'flag-icon-ws' ? 'selected' : '' }}>🇼🇸 Samoa
                                                </option>
                                                <option value="flag-icon-ye"
                                                    {{ old('flag_icon') == 'flag-icon-ye' ? 'selected' : '' }}>🇾🇪 Yemen
                                                </option>
                                                <option value="flag-icon-yt"
                                                    {{ old('flag_icon') == 'flag-icon-yt' ? 'selected' : '' }}>🇾🇹
                                                    Mayotte</option>
                                                <option value="flag-icon-za"
                                                    {{ old('flag_icon') == 'flag-icon-za' ? 'selected' : '' }}>🇿🇦 South
                                                    Africa</option>
                                                <option value="flag-icon-zm"
                                                    {{ old('flag_icon') == 'flag-icon-zm' ? 'selected' : '' }}>🇿🇲 Zambia
                                                </option>
                                                <option value="flag-icon-zw"
                                                    {{ old('flag_icon') == 'flag-icon-zw' ? 'selected' : '' }}>🇿🇼
                                                    Zimbabwe</option>
                                            </select>
                                        </div>
                                        @error('flag_icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Select a flag icon for the country</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Country Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="e.g., United States, Egypt, United Kingdom">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="registration_url">Registration URL</label>
                                        <input type="url"
                                            class="form-control @error('registration_url') is-invalid @enderror"
                                            id="registration_url" name="registration_url"
                                            value="{{ old('registration_url') }}"
                                            placeholder="https://nen-global.org/usets">
                                        @error('registration_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Full URL for country-specific registration
                                            page</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number"
                                            class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                            name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Lower numbers appear first in the
                                            dropdown</small>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_active"
                                                name="is_active" value="1"
                                                {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                Active (Show in registration dropdown)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        <strong>Registration URL Preview:</strong><br>
                                        The registration URL will be: <code>https://nen-global.org/<span
                                                id="url-preview">XX</span>ets</code>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Country
                                    </button>
                                    <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        // Update URL preview when code changes
        document.getElementById('code').addEventListener('input', function() {
            const code = this.value.toLowerCase();
            document.getElementById('url-preview').textContent = code || 'XX';

            // Auto-generate flag icon class
            if (code) {
                const flagIcon = 'flag-icon-' + code;
                const flagSelect = document.getElementById('flag_icon');
                // Try to select the matching option in the dropdown
                const option = flagSelect.querySelector(`option[value="${flagIcon}"]`);
                if (option) {
                    flagSelect.value = flagIcon;
                    updateFlagPreview(flagIcon);
                }
            }
        });

        // Auto-uppercase the code field
        document.getElementById('code').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Update flag preview when flag icon dropdown changes
        document.getElementById('flag_icon').addEventListener('change', function() {
            updateFlagPreview(this.value);
        });

        function updateFlagPreview(flagClass) {
            const preview = document.getElementById('flag-preview');
            preview.className = 'flag-icon ' + (flagClass || 'flag-icon-us');
        }
    </script>
@endsection
