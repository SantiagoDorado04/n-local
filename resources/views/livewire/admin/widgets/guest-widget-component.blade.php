<div>
    <style>
        .card {
  display: flex;
  flex-direction: column;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.card-img {
  height: 240px;
  overflow: hidden;
  opacity: 0.8;
}


.card-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-content {
  padding: 24px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  opacity: 0.8;
}

.card-content h2 {
  font-size: 32px;
  margin-bottom: 16px;
}

.card-content p {
  font-size: 18px;
  margin-bottom: 24px;
}

.cta-button {
  display: inline-block;
  background-color: #000;
  color: #fff;
  padding: 12px 24px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}

.cta-button {
  display: inline-block;
  background-color: #9C9AD9;
  color: #fff;
  padding: 12px 24px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}

.cta-button:hover {
  background-color: #D98BBD;
  color: #fff;
}

    </style>
    <div class="row no-margin-bottom">
        <div class="col-lg-12">
            <div class="page-content browse container-fluid">
                <div class="row no-margin-bottom">
                    <div class="col-md-12">
                        <div class="panel panel-bordered" style="margin:0px">
                            <div class="panel-body" style="padding:15px">
                                <div class="row no-margin-bottom">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-img">
                                              <img src="{{ asset('assets/img/membresia.jpg') }}" alt="Membership image">
                                            </div>
                                            <div class="card-content">
                                              <h2>Obtén acceso exclusivo con nuestras membresías</h2>
                                              <p>Disfruta de contenido exclusivo y beneficios adicionales al adquirir una membresía premium en nuestro sitio.</p>
                                              <a href="{{ route('voyager.profile') }}" class="cta-button">Adquiere tu membresía ahora</a>
                                            </div>
                                          </div>
                                          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                                    
                                    