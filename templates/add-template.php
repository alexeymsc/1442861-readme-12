<main class="page__main page__main--adding-post">
      <div class="page__main-section">
        <div class="container">
          <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>

        <div class="adding-post container">
          <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
              <ul class="adding-post__tabs-list filters__list tabs__list">
              <?php foreach ($types as $type):?>
                <li class="adding-post__tabs-item filters__item">
                  <?php if ($chosen_type===$type['type']):?>
                  <a class="adding-post__tabs-link filters__button filters__button--<?=s($type['icon'])?> filters__button--active tabs__item tabs__item--active button">
                  <?php else:?>
                    <a class="adding-post__tabs-link filters__button filters__button--<?=s($type['icon'])?> tabs__item button" href="?content_type=<?=s($type['type'])?>">
                  <?php endif?>
                    <svg class="filters__icon" width="20%" height="40%">
                      <use xlink:href="#icon-filter-<?= s($type['icon']) ?>"></use>
                    </svg>
                    <span><?=s($type['icon'])?></span>
                  </a>
                </li>
              <?php endforeach?>
              </ul> 
            </div>
            <?=$chosen_type?>

            <div class="adding-post__tab-content">
              <section class="adding-post__photo tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления фото</h2>
                <form class="adding-post__form form" action="#" method="post" enctype="multipart/form-data">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      
                      <?php require (__DIR__.'/form-title.php')?>
                      <?php require (__DIR__.'/form-url.php')?>

                      <?php require (__DIR__.'/form-tags.php')?>

                    </div>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                      </ul>
                    </div>
                  </div>
                  <?php require (__DIR__.'/form-image.php')?>

                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__video tabs__content">
                <h2 class="visually-hidden">Форма добавления видео</h2>
                <form class="adding-post__form form" action="#" method="post" enctype="multipart/form-data">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="video-heading" type="text" name="video-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="video-url" type="text" name="video-heading" placeholder="Введите ссылку">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="video-tags" type="text" name="photo-heading" placeholder="Введите ссылку">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                      </ul>
                    </div>
                  </div>

                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__text tabs__content">
                <h2 class="visually-hidden">Форма добавления текста</h2>
                <form class="adding-post__form form" action="#" method="post">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="text-heading" type="text" name="text-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <textarea class="adding-post__textarea form__textarea form__input" id="post-text" placeholder="Введите текст публикации"></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="post-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="post-tags" type="text" name="photo-heading" placeholder="Введите теги">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                        <li class="form__invalid-item">Цитата. Она не должна превышать 70 знаков.</li>
                      </ul>
                    </div>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>  
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__quote tabs__content">
                <h2 class="visually-hidden">Форма добавления цитаты</h2>
                <form class="adding-post__form form" action="#" method="post">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="quote-heading" type="text" name="quote-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" placeholder="Текст цитаты"></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="cite-tags" type="text" name="photo-heading" placeholder="Введите теги">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">

                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                        <li class="form__invalid-item">Цитата. Она не должна превышать 70 знаков.</li>
                      </ul>
                    </div>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>

              <section class="adding-post__link tabs__content">
                <h2 class="visually-hidden">Форма добавления ссылки</h2>
                <form class="adding-post__form form" action="#" method="post">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="link-heading" type="text" name="link-heading" placeholder="Введите заголовок">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="post-link" type="text" name="post-link">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-tags">Теги</label>
                        <div class="form__input-section">
                          <input class="adding-post__input form__input" id="link-tags" type="text" name="photo-heading" placeholder="Введите ссылку">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc">Текст сообщения об ошибке, подробно объясняющий, что не так.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <li class="form__invalid-item">Заголовок. Это поле должно быть заполнено.</li>
                        <li class="form__invalid-item">Цитата. Она не должна превышать 70 знаков.</li>
                      </ul>
                    </div>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </div>
      </div>
    </main>