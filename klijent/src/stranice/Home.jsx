
import Header from '../komponente/Header';
import Footer from '../komponente/Footer';
import Novosti from '../komponente/Novosti';
import Trejleri from '../komponente/Trejleri';
import Istaknuto from '../komponente/Istaknuto';
import Uskoro from '../komponente/Uskoro';
import Trenutno from '../komponente/Trenutno';
import styles from './css/Home.module.css';

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

      <div className={styles.kon}>
      
      
        <Trenutno/>
         <Uskoro/>
      
    
      </div>


      <Trejleri/>

      <Novosti/>
     
      <Footer />
    </>
  );
}

export default Home;