require 'json'

url = "https://www.googleapis.com/webfonts/v1/webfonts?key="
puts "Enter Google Fonts API key: "
key = gets.chomp!

json = `curl -s #{url}#{key} 2>&1`.strip.chomp
json = JSON.parse(json)

fonts = {}

json[ 'items' ].each do |item|
	family = item['family']

	fonts[family] = {
		label: family,
		variants: item['variants'],
		subsets: item['subsets']
	}
end

File.write(File.expand_path(File.join(File.dirname(__FILE__), '..') + '/resources/data/google-fonts.json'), JSON.pretty_generate(fonts))

puts "Updated resources/data/google-fonts"