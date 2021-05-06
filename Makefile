ZIP_FILE = addons-wp-headless.zip

default: $(ZIP_FILE)

$(ZIP_FILE): LICENSE.txt *.php
	zip $@ $^

clean:
	rm -f $(ZIP_FILE)
