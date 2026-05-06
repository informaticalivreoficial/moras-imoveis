<?= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL ?>
<rss version="2.0"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:atom="http://www.w3.org/2005/Atom">

    <channel>
        <title>{{ config('app.name') }} - Imóveis</title>
        <link>{{ url('/') }}</link>
        <description>Últimos imóveis publicados</description>
        <language>pt-br</language>

        <atom:link href="{{ url('/rss') }}" rel="self" type="application/rss+xml" />

        @foreach ($properties as $property)
            <item>
                <title><![CDATA[{{ $property->title }}]]></title>

                <link>{{ url('/imoveis/' . $property->slug) }}</link>

                <guid isPermaLink="true">
                    {{ url('/imoveis/' . $property->slug) }}
                </guid>

                <pubDate>{{ $property->created_at->toRssString() }}</pubDate>

                <description><![CDATA[{{ Str::limit(strip_tags($property->description), 280) }}]]></description>

                @if($property->cover())
                    <media:content 
                        url="{{ $property->cover() }}" 
                        medium="image" />
                @endif

            </item>
        @endforeach

    </channel>
</rss>