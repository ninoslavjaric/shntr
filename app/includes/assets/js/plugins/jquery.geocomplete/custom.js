window.geocompletionSetup = () => {
  const item = $('.js_geocomplete');
  // try {
  //   item.autocomplete('destroy')
  // } catch (e) {
  //   //
  // }
  $('.ui-widget-content').css('z-index', '999999')
  item.autocomplete({
    delay: 500,
    create: function(evt, ui) {
      $(evt.target).after(`<input type="hidden" name="${$(evt.target).attr('name')}_id" value="${$(evt.target).data('id') || ''}">`)
    },
    source: function(req, res) {
      const _this = $(this.element);
      const lsKey = 'autocomplete-geo';
      if (!sessionStorage.getItem(lsKey)) {
        sessionStorage.setItem(lsKey, JSON.stringify({}));
      }

      const cache = JSON.parse(sessionStorage.getItem(lsKey));

      if (cache[req.term]) {
        return res(cache[req.term]);
      }

      $.get(`/includes/ajax/geo/suggest.php?type=${_this.data('type')}&query=${req.term}`, function (data) {
        cache[req.term] = data.map(item => ({value: item.city_id, label: item.value}));
        sessionStorage.setItem(lsKey, JSON.stringify(cache));
        return res(cache[req.term])
      })
    },
    select: function(evt, ui) {
      evt.preventDefault();
      $(evt.target).val(ui.item.label).next().val(ui.item.value);
    },
    close: function(evt, ui) {
      if ($(evt.target).next().val().trim() === '') {
        $(evt.target).val('');
      }
    },
    focus: function(evt, ui) {
      $(evt.target).data('initial', $(evt.target).val());
    }
  }).blur(function(evt) {
    if ($(evt.target).next().val().trim() === '') {
      $(evt.target).val($(evt.target).data('initial') || '');
      $(evt.target).data('initial', '');
    }
  });
}
$(geocompletionSetup);
