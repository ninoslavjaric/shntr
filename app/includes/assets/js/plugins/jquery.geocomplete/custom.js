window.geocompletionSetup = () => {
  const item = $('.js_geocomplete');
  // try {
  //   item.autocomplete('destroy')
  // } catch (e) {
  //   //
  // }
  const lsKey = 'autocomplete-geo';
  if (!sessionStorage.getItem(lsKey)) {
    sessionStorage.setItem(lsKey, JSON.stringify({}));
  }
  const cache = JSON.parse(sessionStorage.getItem(lsKey));
  let selectedText = '';

  const getSuggestion = function(term, target, callback)
  {
    if (cache[term]) {
      return callback(cache[term]);
    }

    $.get(`/includes/ajax/geo/suggest.php?type=${target.data('type') || 'places'}&query=${term}`, function (data) {
      cache[term] = data.map(item => ({value: item.city_id, label: item.value}));
      sessionStorage.setItem(lsKey, JSON.stringify(cache));
      return callback(cache[term])
    })
  }

  $('.ui-widget-content').css('z-index', '999999')
  item.autocomplete({
    delay: 0,
    change: function(evt, ui) {
      const _target = $(evt.target);

      if (selectedText.trim() === _target.val().trim()) {
        return;
      }

      getSuggestion(_target.val(), _target, function(result) {
        if (result.length === 0) {
          return _target.next().val(null);
        }
        const firstItem = result.shift();
        _target.val(firstItem.label).next().val(firstItem.value);
      });
    },
    create: function(evt, ui) {
      $(evt.target).after(`<input type="hidden" name="${$(evt.target).attr('name')}_id" value="${$(evt.target).data('id') || ''}">`)
    },
    // close: function(evt, ui) {
    //   debugger
    //   // if ($(evt.target).next().val().trim() === '') {
    //   //   // const items = sessionStorage.getItem(lsKey);
    //   //   $(evt.target).val('');
    //   // }
    // },
    source: function(req, res) {
      if (req.term.length < 3) {
        return res([]);
      }

      getSuggestion(req.term, $(this.element), res);
    },
    select: function(evt, ui) {
      evt.preventDefault();
      selectedText = ui.item.label;
      $(evt.target).val(ui.item.label).next().val(ui.item.value);
    },
    // focus: function(evt, ui) {
    //   console.log(123);
    //   // $(evt.target).data('initial', $(evt.target).val());
    // }
  });
  // item.focus((ev) => $(ev.target).val('').next().val(''))
}
$(geocompletionSetup);
