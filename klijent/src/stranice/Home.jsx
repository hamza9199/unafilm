
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Novosti from '../komponente/Novosti';
import Trejleri from '../komponente/Trejleri';
import Istaknuto from '../komponente/Istaknuto';

function Home() {
  //const [movies, setMovies] = useState([]);

  /*useEffect(() => {
    axios.get('http://localhost:5000/movies')
      .then(response => setMovies(response.data))
      .catch(error => console.error(error));
  }, []);*/



  return (
    <>
      <Header />

      <Istaknuto/>

      <Trejleri/>

      <Novosti/>
     
      <Footer />
    </>
  );
}

export default Home;